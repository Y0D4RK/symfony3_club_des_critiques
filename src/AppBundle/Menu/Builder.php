<?php

namespace AppBundle\Menu;

use AppBundle\AppBundle;
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
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {
            $menu->addChild('Accueil', array('route' => 'home'));
            $menu->addChild('Salons', array('route' => 'room_index'));
        }else {
            $menu->addChild('Accueil', array('route' => 'home'));
        }
        return $menu;
    }

    public function categoryMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root', array(
            'childrenAttributes'    => array(
                'class'             => 'dropdown-menu',
            )
        ));
        if ($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')) {

            $em = $this->container->get('doctrine.orm.entity_manager');
            $repository = $em->getRepository('AppBundle:Category');
            $categories = $repository->findAll();

            foreach($categories as $category){
                $menu->addChild(ucfirst($category->getName()), array(
                    'route' => 'artwork_index',
                    'routeParameters' => array('name' => $category->getName())
                ));
            }
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
            $menu->addChild('Se deconnecter', array('route' => 'fos_user_security_logout'));
            /** @var \UserBundle\Entity\User $userLogged */
            $userLogged = $this->container->get('security.token_storage')->getToken()->getUser();
            $menu->addChild(ucfirst($userLogged->getUsername()), array('route' => 'fos_user_profile_show'));

            if ($this->container->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {

                $em = $this->container->get('doctrine.orm.entity_manager');
                $repository = $em->getRepository('AppBundle:Design');
                $design = $repository->find('1');

                $menu->addChild('Administration', array(
                    'route' => 'admin',
                    'routeParameters' => array('id' => $design->getId())));
            }
        }else{
            $menu->addChild('Se connecter', array('route' => 'fos_user_security_login'));
            $menu->addChild('S\'inscrire', array('route' => 'fos_user_registration_register'));
        }

        return $menu;
    }
}