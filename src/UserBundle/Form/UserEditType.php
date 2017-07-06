<?php

namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

use Symfony\Component\Validator\Constraints\DateTime;
use Vich\UploaderBundle\Form\Type\VichFileType;

class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('avatar', VichFileType::class, [
                'allow_delete' => false,
                'download_link' => true,
                'required' => false,
                'label' => ' '
            ])
            ->add('email', EmailType::class, ['label'=>'Email', 'attr'=>array('placeholder'=>'j.doe@mail.com')])
            ->add('firstname', TextType::class, ['label'=>'Prenom', 'attr'=>array('placeholder'=>'John')])
            ->add('lastname', TextType::class, ['label'=>'Name', 'attr'=>array('placeholder'=>'Doe')])
            ->add('birthdate', DateType::class, ['label'=>'Date de naissance', 'attr'=>array('placeholder'=>'')])
            ->add('description', TextareaType::class, ['label'=>'Description', 'attr'=>array('placeholder'=>'La la la ...', 'rows' => '5', 'style' => 'resize:none')]);
            #->remove('username');
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }
}