<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LandingController extends Controller
{
    /** Page index **/
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'title' => "Le Club des Critiques",
            'label_email' => "Rejoignez notre club en saisissant simplement votre email",
            'label_email' => "Rejoignez notre club en saisissant simplement votre email",
            'label_email' => "Rejoignez notre club en saisissant simplement votre email",
        ]);
    }

}
