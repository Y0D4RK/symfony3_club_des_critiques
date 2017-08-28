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
        $artworksShared = $em->getRepository('AppBundle:Sharing')->findBy(array('user' => $user));

        //Récupérer les salons crées par l'utilisateur
        $rooms = $em->getRepository('ChatBundle:Room')->findBy(array('creator' => $user));


        //Utilisateur connecté
        $current_user = $this->getUser();

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'artworksShared' => $artworksShared,
            'user' => $user,
            'current_user' => $current_user,
            'rooms' => $rooms,
        ));
    }
    
}
