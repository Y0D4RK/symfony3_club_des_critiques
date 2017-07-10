<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class AdminController extends Controller
{
    /** Page index admin**/
    public function indexAction(Request $request)
    {
        return $this->render('club/admin/index.html.twig');
    }

}
