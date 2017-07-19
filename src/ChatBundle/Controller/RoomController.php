<?php

namespace ChatBundle\Controller;

use ChatBundle\Entity\Room;
use AppBundle\Entity\Artwork;
use UserBundle\Entity\User;
use UserBundle\Entity\Score;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use ChatBundle\Command\SocketCommand;


/**
 * Room controller.
 *
 */
class RoomController extends Controller
{
    /**
     * Lists all room entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $rooms = $em->getRepository('ChatBundle:Room')->findAll();

        return $this->render('ChatBundle:Room:index.html.twig', array(
            'rooms' => $rooms,
        ));
    }

    /**
     * Creates a new room entity.
     *
     */
    public function newAction(Request $request)
    {
        $room = new Room();
        $form = $this->createForm('ChatBundle\Form\RoomType', $room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $room->setCreator($this->getUser());
            $room->setRoute("/room/".$room->getId().'/show');
            $room->setCreator($this->getUser());

            $em->persist($room);
            $em->flush($room);

            return $this->redirectToRoute('room_show', array('id' => $room->getId()));
        }

        return $this->render('ChatBundle:Room:new.html.twig', array(
            'room' => $room,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a room entity.
     *
     */
    public function showAction(Room $room)
    {
        $route = new SocketCommand();
        $em = $this->getDoctrine()->getManager();
        $rooms = $em->getRepository('ChatBundle:Room')->findAll();


        $user = $this->getUser();

        $deleteForm = $this->createDeleteForm($room);

        //Verifier si l'user a deja voté pour cette oeuvre
        $scores = $em->getRepository('AppBundle:Score')->findAll();
        $voted = false;
        foreach ($scores as $score){
            if ($score->getUser()->getId() == $user->getId()){
                if($score->getArtwork()->getId() == $room->getArtwork()->getId()){
                    $voted = true;
                }
            }
        }

        return $this->render('ChatBundle:Room:show.html.twig', array(
            'user' => $user,
            'room' => $room,
            'voted' => $voted,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing room entity.
     *
     */
    public function editAction(Request $request, Room $room)
    {
        $deleteForm = $this->createDeleteForm($room);
        $editForm = $this->createForm('ChatBundle\Form\RoomType', $room);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('room_edit', array('id' => $room->getId()));
        }

        return $this->render('ChatBundle:Room:edit.html.twig', array(
            'room' => $room,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a room entity.
     *
     */
    public function deleteAction(Request $request, Room $room)
    {
        $form = $this->createDeleteForm($room);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($room);
            $em->flush($room);
        }

        return $this->redirectToRoute('room_index');
    }

    /**
     * Creates a form to delete a room entity.
     *
     * @param Room $room The room entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Room $room)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('room_delete', array('id' => $room->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
