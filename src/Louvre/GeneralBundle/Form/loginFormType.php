<?php

namespace Louvre\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;


class loginFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('_username', EmailType::class, array(
            'label' => 'Email de l\'utilisateur',
        ))
        ->add('_password', PasswordType::class, array(
            'label' => 'Mot de passe',
        ));
    }
}