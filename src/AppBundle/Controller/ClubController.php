<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ClubController extends Controller
{
    /** Page index **/
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'var' => "YO LES PELOS ! Ici les l'acceuil."
        ]);
    }

    /** Page movie **/
    public function movieAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'var' => "MOVIE X !"
        ]);
    }

    /** Page book **/
    public function bookAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'var' => "BOOK X !"
        ]);
    }

    /** Page exposition **/
    public function expositionAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'var' => "EXPOSITION X !"
        ]);
    }

}
