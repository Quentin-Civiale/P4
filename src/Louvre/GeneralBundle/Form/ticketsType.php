<?php

namespace Louvre\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;

class ticketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Formulaire en php
        $builder
            ->add('email', EmailType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('sexe', ChoiceType::class, array('choices' => array('homme' => 'homme', 'femme' => 'femme'), 'expanded' => true))
            ->add('date', DateType::class)
            ->add('envoyer', SubmitType::class)
            ;
    }
    
    public function getName()
    {
        return 'louvre_generalbundle_tickets';
    }
}
