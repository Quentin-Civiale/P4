<?php

namespace Louvre\GeneralBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Louvre\GeneralBundle\Entity\Commandes;
use Louvre\GeneralBundle\Entity\Tickets;
use Symfony\Component\HttpFoundation\Request;


class commandesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Formulaire en php
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('date', DateType::class, array(
                 'widget' => 'choice',
                 'years' => range(date('Y'), date('Y')+10),
                 'months' => range(date('m'), 12),
                 'days' => range(date('d'), 31),
                 'label' => 'Date de visite',
               ))
            ->add('email', EmailType::class)
            ->add('statut', TextType::class)
//            ->add('tickets', ticketsType::class);
            ->add('tickets', CollectionType::class, array(
                'entry_type' => ticketsType::class,
                'allow_add' => true,
//                'allow_delete' => true,
                'prototype' => true,
                'by_reference' => false,
                'entry_options'  => array(
                'attr' => array('class' => 'tickets')),
            ))
            ->getForm();
        
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commandes::class
        ]);
    }
    
}
