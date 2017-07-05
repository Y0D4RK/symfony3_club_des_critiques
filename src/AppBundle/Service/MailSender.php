<?php

namespace AppBundle\Service;


/**
 * Mail sender with swiftmailer
 *
 */
class MailSender{

    public function sendMail($name, $email, $content, \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('subject'))
            ->setTo($email)
            ->setBody(
                $this->renderView(
                    'email/contactus.html.twig',
                    array(
                        'name' => $name,
                        'email' => $email,
                        'content' => $content
                    )
                ),
                'text/html'
            )
            /*
             * If you also want to include a plaintext version of the message
            ->addPart(
                $this->renderView(
                    'Emails/registration.txt.twig',
                    array('name' => $name)
                ),
                'text/plain'
            )
            */
        ;

        $mailer->send($message);

        // or, you can also fetch the mailer service this way
        // $this->get('mailer')->send($message);

        return $this->render(...);
    }
}