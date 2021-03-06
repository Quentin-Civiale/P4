<?php

namespace Louvre\GeneralBundle\Form;

use Louvre\GeneralBundle\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class bookingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Formulaire en php
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('date', DateTimeType::class, [
                 'attr' => array('class' => 'datepicker'),
                 'widget' => 'single_text',
                 'label' => 'Date de la visite',
                 'format' => 'dd/MM/yyyy',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Journée (de 9h à 18h)' => 'journee',
                    'Demi-journée (de 14h à 18h)' => 'demi-journee',
                ],
                'expanded' => true,
                'multiple' => false,
                'data' => 'journee',
            ])
            ->add('email', EmailType::class)
            ->add('tickets', CollectionType::class, [
                'entry_type' => ticketType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->add('registration', CheckboxType::class)
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
