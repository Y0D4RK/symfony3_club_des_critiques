<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LandingController extends Controller
{
    /** Page index **/
    public function indexAction(Request $request)
    {
        $limit = 3;
        $offset = 0;
        $em = $this->getDoctrine()->getManager();
        $artworks = $em->getRepository('AppBundle:Artwork')->findBy(array(), null, $limit, $offset);


        $em = $this->getDoctrine()->getManager();
        $design = $em->getRepository('AppBundle:Design')->find(1);

        // replace this example code with whatever you need
        return $this->render('club/index.html.twig', [
            
            'artworks' => $artworks,
            'design' => $design
        ]);
    }

}
