<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Artwork;
use AppBundle\Entity\Score;
use AppBundle\Entity\Sharing;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Artwork controller.
 *
 */
class ArtworkController extends Controller
{
    /**
     * Lists all artworks entities find by category.
     *
     */
    public function indexAction($name)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AppBundle:Category')->findBy(array('name'=>$name));

        if (null === $category) {
            throw new NotFoundHttpException("La cateogrie ".$name." n'existe pas.");
        }

        $artworks = $em->getRepository('AppBundle:Artwork')->findBy(array('category' => $category), ['name' => 'ASC']);

        return $this->render('club/artwork/index.html.twig', array(
          'category' => $category,
            'artworks' => $artworks
        ));
    }
    /**
     * Creates a new artwork entity.
     *
     */
    public function newAction(Request $request, $name)
    {
        $artwork = new Artwork();
        $form = $this->createForm('AppBundle\Form\ArtworkType', $artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artwork->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();

            $em->persist($artwork);
            $em->flush($artwork);

            return $this->redirectToRoute('artwork_show', array('id' => $artwork->getId()));
        }

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        $tab_categories = [];
        foreach($categories as $category){
            $tab_categories[] = $category->getName();
        }

        $category = $request->get('name');


        if(!in_array($category, $tab_categories, true)){
            throw new NotFoundHttpException("La categorie ".$name." n'existe pas.");
        }

        return $this->render('club/artwork/new.html.twig', array(
            'categoryName' => $category,
            'artwork' => $artwork,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a artwork entity.
     *
     */
    public function showAction(Request $request, Artwork $artwork)
    {
        $em = $this->getDoctrine()->getManager();

        $artworksSimilary = $em->getRepository('AppBundle:Artwork')->findBy(array('category' => $artwork->getCategory()));

        $artworkShared = $em->getRepository('AppBundle:Sharing')->findBy(array('artwork' => $artwork));

        $deleteForm = $this->createDeleteForm($artwork);

        //Récupérer l'id de l'utilisaateur courrant
        $user = $this->getUser();
        $currentUserName = $user->getUsername();

        //Savoir si l'utilisateur a déja partagé cette oeuvre
        $alreadyShared = FALSE;

        foreach($artworkShared as $bookUser){
          if ($bookUser->getUser()->getId() == $user->getId()){
              $alreadyShared = TRUE;
          }
        }

        //Vote artwork
        $score = $artwork->getScore();      //Récupérer le score de l'artwork
        $vote = $request->request->get('vote');     //Récupérer le vote en js

        if (isset($vote)){
            $score = $artwork->getScore(); // 3 - car (5 + 1) / 2
            $nb_votes = $artwork->getVoteCount(); // 2

            $new_score = (($score * $nb_votes) + $vote) / ($nb_votes + 1);      //On calcule le nouveau score
            $new_score = round($new_score);

            $new_nb_votes = $nb_votes + 1;

            //Verifier si l'user a deja voté pour cette oeuvre
            $scores = $em->getRepository('AppBundle:Score')->findAll();
            $tmp = true;
            $currentUser = $this->getUser(); // dump($scores);
            foreach ($scores as $score){
                if ($score->getUser()->getId() == $currentUser->getId()){
                    if($score->getArtwork()->getId() == $artwork->getId()){
                        $tmp = false;
                    }
                }
            }

            if ($tmp){
                //On insere le nouveau vote dans artwork et le nb_votes
                $artwork->setScore($new_score);
                $artwork->setVoteCount($new_nb_votes);
                $em->persist($artwork);
                $em->flush();

                //On insere le vote dans la table score
                $score = new Score();
                $score->setArtwork($artwork);
                $score->setUser($user);
                $score->setCreatedAt(new \DateTime('now'));
                $score->setVote($vote);
                $em->persist($score);
                $em->flush();

                $message = "Votre vote est prit en compte";
            }else{
                $new_score = $score = $artwork->getScore();     //Récupérer l'acien score pour le js
                $message = "Vous avez déjà voté pour cette oeuvre";
            }

            header('Content-type: application/json');
            $record = [];
            $record['success'] = $new_score;
            $record['message'] = $message;
            die(json_encode($record));

        }

        return $this->render('club/artwork/show.html.twig', array(
            'user' => $user,
            'artworksSimilary' => $artworksSimilary,
            'artwork' => $artwork,
            'delete_form' => $deleteForm->createView(),
            'currentUserName' => $currentUserName,
            'score' => $score,
            'usersWhoShare' => $artworkShared,
            'alreadyShared'=> $alreadyShared
        ));
    }

    /**
     * Displays a form to edit an existing artwork entity.
     *
     */
    public function editAction(Request $request, Artwork $artwork)
    {
        $deleteForm = $this->createDeleteForm($artwork);
        $editForm = $this->createForm('AppBundle\Form\ArtworkType', $artwork);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('artwork_edit', array('id' => $artwork->getId()));
        }

        return $this->render('club/artwork/edit.html.twig', array(
            'artwork' => $artwork,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a artwork entity.
     *
     */
    public function deleteAction(Request $request, Artwork $artwork)
    {
        $form = $this->createDeleteForm($artwork);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($artwork);
            $em->flush($artwork);
        }

        $nameCategory = $artwork->getCategory();
        return $this->redirectToRoute('artwork_index', array('name' => $nameCategory));
    }

    /**
     * Creates a form to delete a artwork entity.
     *
     * @param Artwork $artwork The artwork entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Artwork $artwork)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('artwork_delete', array('id' => $artwork->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Sharing an artwork on his profile.
     *
     */
    public function sharingAction(Artwork $artwork)
    {
      $sharing = new Sharing();

      $sharing->setUser($this->getUser());
      $sharing->setArtwork($artwork);

      $em = $this->getDoctrine()->getManager();

      $em->persist($sharing);
      $em->flush($sharing);

      return $this->redirectToRoute('fos_user_profile_show');
    }

    public function unsharingAction(Artwork $artwork)
    {
      $sharing = new Sharing();
      $current_user = $this->getUser();

      $em = $this->getDoctrine()->getManager();
      $sharing = $em->getRepository('AppBundle:Sharing')->findBy(array('user' => $current_user, 'artwork' => $artwork->getId()));

      foreach($sharing as $artworkToUnshare){
        //dump($artworkToUnshare); exit();
        $em->remove($artworkToUnshare);
      }

      $em->flush();

      return $this->redirectToRoute('fos_user_profile_show');
    }
}
