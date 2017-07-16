<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Score;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Score controller.
 *
 */
class ScoreController extends Controller
{
    /**
     * Lists all score entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $scores = $em->getRepository('AppBundle:Score')->findAll();

        return $this->render('score/index.html.twig', array(
            'scores' => $scores,
        ));
    }

    /**
     * Creates a new score entity.
     *
     */
    public function newAction(Request $request)
    {
        $score = new Score();
        $form = $this->createForm('AppBundle\Form\ScoreType', $score);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($score);
            $em->flush($score);

            return $this->redirectToRoute('score_show', array('id' => $score->getId()));
        }

        return $this->render('score/new.html.twig', array(
            'score' => $score,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a score entity.
     *
     */
    public function showAction(Score $score)
    {
        $deleteForm = $this->createDeleteForm($score);

        return $this->render('score/show.html.twig', array(
            'score' => $score,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing score entity.
     *
     */
    public function editAction(Request $request, Score $score)
    {
        $deleteForm = $this->createDeleteForm($score);
        $editForm = $this->createForm('AppBundle\Form\ScoreType', $score);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('score_edit', array('id' => $score->getId()));
        }

        return $this->render('score/edit.html.twig', array(
            'score' => $score,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a score entity.
     *
     */
    public function deleteAction(Request $request, Score $score)
    {
        $form = $this->createDeleteForm($score);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($score);
            $em->flush($score);
        }

        return $this->redirectToRoute('score_index');
    }

    /**
     * Creates a form to delete a score entity.
     *
     * @param Score $score The score entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Score $score)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('score_delete', array('id' => $score->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
