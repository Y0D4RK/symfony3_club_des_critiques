<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LandingController extends Controller
{
    /** Page index **/
    public function indexAction(Request $request)
    {

        /** formulaire de contact **/
        $form = $this->createForm('AppBundle\Form\ContactType',null,array(
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

        /** logique de base de la landing page **/
        $limit = 3;
        $offset = 0;
        $em = $this->getDoctrine()->getManager();
        // Recupération des trois dernières oeuvres crées
        $artworks = $em->getRepository('AppBundle:Artwork')->findBy(array(), array('id' => 'desc'), $limit, $offset);

        $em = $this->getDoctrine()->getManager();
        $design = $em->getRepository('AppBundle:Design')->find(1);

        return $this->render('club/index.html.twig', [
            'form' => $form->createView(),
            'artworks' => $artworks,
            'design' => $design
        ]);
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
