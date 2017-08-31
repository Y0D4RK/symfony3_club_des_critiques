<?php

namespace UserBundle\Controller;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\Controller\ProfileController as BaseController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\UserEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;

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

        $request = $this->container->get('request_stack')->getCurrentRequest();
        /** formulaire de contact **/
        $form = $this->createForm('UserBundle\Form\ContactType',null,array(
            'action' => $this->generateUrl('home'),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if($form->isValid()){
                // Send mail
                if($this->sendEmail($form->getData())){
                    return $this->redirectToRoute('home');
                }else{
                    // An error ocurred, handle
                    var_dump("Erreur");
                }
            }
        }

        $em = $this->getDoctrine()->getManager();
        $artworksShared = $em->getRepository('AppBundle:Sharing')->findBy(array('user' => $user));

        //Récupérer les salons crées par l'utilisateur
        $rooms = $em->getRepository('ChatBundle:Room')->findBy(array('creator' => $user));


        //Utilisateur connecté
        $current_user = $this->getUser();

        return $this->render('@FOSUser/Profile/show.html.twig', array(
            'form' => $form->createView(),
            'artworksShared' => $artworksShared,
            'user' => $user,
            'current_user' => $current_user,
            'rooms' => $rooms,
        ));
    }

    private function sendEmail($data){

        $contactMail = $this->container->getParameter('mailer_user');
        $contactPassword = $this->container->getParameter('mailer_password');

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($contactMail)
            ->setPassword($contactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $text = "Email expéditeur: ".$data['email']."\n Message: ".$data['message'];

        $message = \Swift_Message::newInstance("Formulaire de contact -". $data["subject"])
            ->setFrom(array(
                $contactMail => "Message envoyé par ".$data["name"]))
            ->setTo(array(
                $contactMail => $contactMail
            ))
            ->setBody($text);

        return $mailer->send($message);
    }

}
