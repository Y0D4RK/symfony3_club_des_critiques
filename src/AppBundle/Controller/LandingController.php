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
        $artworks = $em->getRepository('AppBundle:Artwork')->findBy(array(), null, $limit, $offset);

        $em = $this->getDoctrine()->getManager();
        $design = $em->getRepository('AppBundle:Design')->find(1);

        return $this->render('club/index.html.twig', [
            'form' => $form->createView(),
            'artworks' => $artworks,
            'design' => $design
        ]);
    }

    private function sendEmail($data){
        $myappContactMail = 'esgigroupeone@gmail.com';
        $myappContactPassword = 'pwdGROUPE1';


        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465,'ssl')
            ->setUsername($myappContactMail)
            ->setPassword($myappContactPassword);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance("Our Code World Contact Form ". $data["subject"])
            ->setFrom(array($myappContactMail => "Message by ".$data["name"]))
            ->setTo(array(
                $myappContactMail => $myappContactMail
            ))
            ->setBody($data["message"]."<br>ContactMail :".$data["email"]);

        return $mailer->send($message);
    }
}
