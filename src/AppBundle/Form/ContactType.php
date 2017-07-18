<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('attr' => array('placeholder' => 'Votre prénom..'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez insérer un email valide")),
                )
            ))
            ->add('subject', TextType::class, array('attr' => array('placeholder' => 'Le sujet'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez insérer un sujet")),
                )
            ))
            ->add('email', EmailType::class, array('attr' => array('placeholder' => 'Votre adresse email..'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez insérer un email valid")),
                    new Email(array("message" => "Votre email ne semble pas valide")),
                )
            ))
            ->add('message', TextareaType::class, array('attr' => array('placeholder' => 'Votre contenu ici..'),
                'constraints' => array(
                    new NotBlank(array("message" => "Veuillez insérer un contenu")),
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'error_bubbling' => true
        ));
    }

    public function getName()
    {
        return 'contact_form';
    }
}