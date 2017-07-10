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


//        $em = $this->getDoctrine()->getManager();
//        $interface = $em->getRepository('AppBundle:Interface')->findAll();

        // replace this example code with whatever you need
        return $this->render('club/index.html.twig', [
            
            'artworks' => $artworks,
            'title' => "Le Club des Critiques",
            'slogan' => "Le cluuuuuuuuuuuuuuuuuuuuuuub de fouu",

            'title1' => "Nos Idée",
            'title2' => "Concept",
            'title3' => "Lorem ipsum",

            'text1' => "Lorem ipsum empty",
            'text2' => "Le Club des Critiques",
            'text3' => "Le Club des Critiques",
            'text4' => "Le Club des Critiques"
        ]);
    }

}
