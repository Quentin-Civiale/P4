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
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Louvre\GeneralBundle\Entity\Commande;
use Louvre\GeneralBundle\Entity\Tickets;


class ticketsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Formulaire en php
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('dateNaissance', BirthdayType::class, array(
                'label' => 'Date de naissance',
                'placeholder' => array(
                'year' => 'Année', 'month' => 'Mois', 'day' => 'Jour',
                ))
                )
            ->add('prix', NumberType::class);
    }
    
//    public function getName()
//    {
//        return 'louvre_generalbundle_tickets';
//    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'Louvre\GeneralBundle\Entity\Tickets'));
    }
    
}
