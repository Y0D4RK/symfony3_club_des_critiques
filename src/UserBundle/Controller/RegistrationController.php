<?php

namespace UserBundle\Controller;

use FOS\UserBundle\Event\GetResponseUserEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\Controller\RegistrationController as BaseController;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\FOSUserEvents;

class RegistrationController extends BaseController
{
    public function registerAction(Request $request)
    {
        $response = parent::registerAction($request);
        return $response;
    }
}