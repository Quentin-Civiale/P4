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
use Louvre\GeneralBundle\Entity\Commande;
use Louvre\GeneralBundle\Entity\Ticket;
use Symfony\Component\HttpFoundation\Request;


class commandeType extends AbstractType
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
//            ->add('statut', TextType::class)
            ->add('tickets', CollectionType::class, array(
                'entry_type' => ticketType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ))
            ->getForm();
        
        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class
        ]);
    }
    
}
