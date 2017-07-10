<?php

namespace UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends BaseController
{
    public function showAction()
    {
        $user = $this->getUser();

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('AppBundle:Category')->findAll();

        $artworks = $em->getRepository('AppBundle:Artwork')->findBy(array('user' => $user));

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'artworksUser' => $artworks,
            'categories' => $categories,
            'user' => $user,
        ));
    }
}