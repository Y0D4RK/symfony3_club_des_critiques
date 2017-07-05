<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /** Page index admin**/
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('club/admin/index.html.twig');
    }

}
