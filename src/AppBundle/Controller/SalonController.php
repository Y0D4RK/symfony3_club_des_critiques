<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SalonController extends Controller
{
    /** Page index **/
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('club/salon/salons.html.twig');
    }

}
