<?php

namespace Louvre\GeneralBundle\Form;

use Louvre\GeneralBundle\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
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
//                 'widget' => 'single_text',
                 'years' => range(date('Y'), date('Y') + 2),
                 'months' => range(1, 12),
                 'days' => range(1, 31),
                 'label' => 'Date de la visite',
                 'placeholder' => 'Sélectionner une valeur',
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
//            ->add('statut', TextType::class)
            ->add('tickets', CollectionType::class, [
                'entry_type' => ticketType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ])
            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
