<?php

namespace UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use FOS\UserBundle\Event\FilterUserResponseEvent;


class RegistrationListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_CONFIRMED => 'onRegistrationSuccess'
        );
    }

    public function onRegistrationSuccess()
    {
        $roles = array('ROLE_USER');
        $user = $event->getForm()->getData();
        $user->setRoles($roles);
    }
}