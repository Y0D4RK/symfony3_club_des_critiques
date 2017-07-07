<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Design;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Design controller.
 *
 */
class DesignController extends Controller
{
    /**
     * Lists all design entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $designs = $em->getRepository('AppBundle:Design')->findAll();

        return $this->render('design/index.html.twig', array(
            'designs' => $designs,
        ));
    }

    /**
     * Creates a new design entity.
     *
     */
    /*public function newAction(Request $request)
    {
        $design = new Design();
        $form = $this->createForm('AppBundle\Form\DesignType', $design);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($design);
            $em->flush($design);

            return $this->redirectToRoute('design_show', array('id' => $design->getId()));
        }

        return $this->render('design/new.html.twig', array(
            'design' => $design,
            'form' => $form->createView(),
        ));
    }*/

    /**
     * Finds and displays a design entity.
     *
     *//*
    public function showAction(Design $design)
    {
        $deleteForm = $this->createDeleteForm($design);

        return $this->render('design/show.html.twig', array(
            'design' => $design,
            'delete_form' => $deleteForm->createView(),
        ));
    }*/

    /**
     * Displays a form to edit an existing design entity.
     *
     */
    public function editAction(Request $request, Design $design)
    {
        $deleteForm = $this->createDeleteForm($design);
        $editForm = $this->createForm('AppBundle\Form\DesignType', $design);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('design_edit', array('id' => $design->getId()));
        }

        return $this->render('design/edit.html.twig', array(
            'design' => $design,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a design entity.
     *
     */
    public function deleteAction(Request $request, Design $design)
    {
        $form = $this->createDeleteForm($design);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($design);
            $em->flush($design);
        }

        return $this->redirectToRoute('design_index');
    }

    /**
     * Creates a form to delete a design entity.
     *
     * @param Design $design The design entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Design $design)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('design_delete', array('id' => $design->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
