<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;


class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav',
            )
        ));
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
            $menu->addChild('Home', array('route' => 'home'));
            $menu->addChild('Catégories', array('route' => 'game_template'));
            $menu->addChild('Salons', array('route' => 'game_index'));
        }else {
            $menu->addChild('Dashboard', array('route' => 'home'));
        }
        return $menu;
    }
    public function logMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'nav navbar-nav navbar-right',
            )
        ));

        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $menu->addChild('Log out', array('route' => 'fos_user_security_logout'));
            /** @var \UserBundle\Entity\User $userLogged */
            $userLogged = $this->container->get('security.token_storage')->getToken()->getUser();
            $menu->addChild($userLogged->getName(), array('route' => 'fos_user_profile_edit'));
        }else{
            $menu->addChild('login', array('route' => 'fos_user_security_login'));
        }

        return $menu;
    }
}