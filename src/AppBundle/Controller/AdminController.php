<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Design;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /** Page index admin**/

    public function indexAction(Request $request, Design $design)
    {
        $editForm = $this->createForm('AppBundle\Form\DesignType', $design);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin', array('id' => $design->getId()));
        }

        return $this->render('club/admin/index.html.twig', array(
            'design' => $design,
            'edit_form' => $editForm->createView(),
        ));
    }
}
