<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Artwork;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Artwork controller.
 *
 */
class ArtworkController extends Controller
{
    /**
     * Lists all artwork entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artworks = $em->getRepository('AppBundle:Artwork')->findAll();

        return $this->render('artwork/index.html.twig', array(
            'artworks' => $artworks,
        ));
    }

    /**
     * Creates a new artwork entity.
     *
     */
    public function newAction(Request $request)
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

        return $this->render('artwork/new.html.twig', array(
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
        $deleteForm = $this->createDeleteForm($artwork);

        return $this->render('artwork/show.html.twig', array(
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

        return $this->render('artwork/edit.html.twig', array(
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

        return $this->redirectToRoute('artwork_index');
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
