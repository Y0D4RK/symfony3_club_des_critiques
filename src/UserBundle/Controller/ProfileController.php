<?php

namespace UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileController extends BaseController
{
    public function showAction(\UserBundle\Entity\User $user=null)
    {
        if ($user == null){
            $user = $this->getUser();
        }

        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('This user does not have access to this section.');
        }

        $em = $this->getDoctrine()->getManager();
        $artworks = $em->getRepository('AppBundle:Artwork')->findBy(array('user' => $user));

        //Utilisateur connecté
        $current_user = $this->getUser();

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'artworksUser' => $artworks,
            'user' => $user,
            'current_user' => $current_user,
        ));
    }
}