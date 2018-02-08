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
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Louvre\GeneralBundle\Entity\Commandes;
use Symfony\Component\HttpFoundation\Request;


class commandesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Formulaire en php
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('date', DateType::class, array('format' => 'dd/MM/yyyy'))
            ->add('email', EmailType::class)
            ->add('statut', TextType::class)
//            ->add('tickets', ticketsType::class);
            ->add('tickets', CollectionType::class, array(
                'entry_type' => ticketsType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'entry_options'  => array(
                'attr' => array('class' => 'tickets')),
            ))
            ->getForm();
        
        
    }
    
//    public function getName()
//    {
//        return 'louvre_generalbundle_commandes';
//    }

        public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
    
}
