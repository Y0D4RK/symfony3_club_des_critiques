<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Artwork;
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

        $artworks = $em->getRepository('AppBundle:Artwork')->findBy(array('category' => $category));

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

        //        $em = $this->getDoctrine()->getManager();
        //        $categoryName = $this->getRepository('AppBundle:Category')->findAll();

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
    public function showAction(Artwork $artwork)
    {
        $em = $this->getDoctrine()->getManager();

        $artworksSimilary = $em->getRepository('AppBundle:Artwork')->findBy(array('category' => $artwork->getCategory()));

        $deleteForm = $this->createDeleteForm($artwork);

        return $this->render('club/artwork/show.html.twig', array(
            'artworksSimilary' => $artworksSimilary,
            'artwork' => $artwork,
            'delete_form' => $deleteForm->createView(),
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
}
