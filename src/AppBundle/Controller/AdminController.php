<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Design;
use AppBundle\Entity\Artwork;
use AppBundle\Entity\Category;
use UserBundle\Entity\User;
use ChatBundle\Entity\Room;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /** Page index admin**/
    public function indexAction(Request $request, Design $design)
    {

        //Form edit Design
        $editForm = $this->createForm('AppBundle\Form\DesignType', $design);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin', array('id' => $design->getId()));
        }

        //Form add Artwork
        $artwork = new Artwork();
        $newArtform = $this->createForm('AppBundle\Form\ArtworkType', $artwork);
        $newArtform->handleRequest($request);

        if ($newArtform->isSubmitted() && $newArtform->isValid()) {
            $artwork->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($artwork);
            $em->flush($artwork);

            return $this->redirectToRoute('admin', array('id' => $design->getId()));
        }

        //show artwork
        $em = $this->getDoctrine()->getManager();
        $artworks = $em->getRepository('AppBundle:Artwork')->findAll();

        //New category
        $category = new Category();
        $category->setCreatedAt(new \DateTime('now'));

        $formNewCategory = $this->createForm('AppBundle\Form\CategoryType', $category);
        $formNewCategory->handleRequest($request);

        if ($formNewCategory->isSubmitted() && $formNewCategory->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($category);
            $em->flush($category);

            return $this->redirectToRoute('admin', array('id' => $design->getId()));
        }

        //List category
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();


        //List users
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('UserBundle:User')->findAll();

        //Form add room
        $room = new Room();
        $newRoomForm = $this->createForm('ChatBundle\Form\RoomType', $room);
        $newRoomForm->handleRequest($request);

        if ($newRoomForm->isSubmitted() && $newRoomForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $room->setCreator($this->getUser());
            $room->setRoute("/room/".$room->getId().'/show');
            $room->setCreator($this->getUser());

            $em->persist($room);
            $em->flush($room);

            return $this->redirectToRoute('admin', array('id' => $design->getId()));
        }

        //List salon
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('ChatBundle:Room')->findAll();

        //Date aujourd'hui
        $now = new \DateTime('now');

        //return variables to admin view
        return $this->render('club/admin/index.html.twig', array(
            'design' => $design,
            'edit_form' => $editForm->createView(),
            'newArtform' => $newArtform->createView(),
            'newRoomForm' => $newRoomForm->createView(),
            'artworks' => $artworks,
            'formNewCategory' => $formNewCategory->createView(),
            'categories' => $categories,
            'users' => $users,
            'rooms' => $rooms,
            'now' => $now,
        ));
    }

    //Delete artwork
    public function deleteAction(Artwork $artwork)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($artwork);
            $em->flush($artwork);

        return $this->redirectToRoute('admin', array('id' => 1));
    }

    //Delete room
    public function deleteRoomAction(Room $room)
    {
            $em = $this->getDoctrine()->getManager();
            $em->remove($room);
            $em->flush($room);

        return $this->redirectToRoute('admin', array('id' => 1));
    }


    //Validate artwork
    public function validateAction(Artwork $artwork)
    {
            $em = $this->getDoctrine()->getManager();
            $artwork->setEnabled(True);
            $em->persist($artwork);
            $em->flush($artwork);

        return $this->redirectToRoute('admin', array('id' => 1));
    }


    //Delete category
    public function deleteCategoryAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush($category);

        return $this->redirectToRoute('admin', array('id' => 1));
    }

    //Ban user
    public function banUserAction (User $user){
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(False);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin', array('id' => 1));
    }

    //Activate user
    public function activateUserAction (User $user){
        $em = $this->getDoctrine()->getManager();
        $user->setEnabled(True);

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin', array('id' => 1));
    }

    //Role user to admin
    public function userToAdminAction (User $user){
        $em = $this->getDoctrine()->getManager();
        $user->setRoles(array('ROLE_ADMIN'));

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin', array('id' => 1));
    }

    //Role user to admin
    public function adminToUserAction (User $user){
        $em = $this->getDoctrine()->getManager();
        $user->setRoles(array('ROLE_USER'));

        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('admin', array('id' => 1));
    }

}
