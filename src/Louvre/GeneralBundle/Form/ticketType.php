<?php

namespace Louvre\GeneralBundle\Form;

use Louvre\GeneralBundle\Entity\Ticket;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ticketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Formulaire en php
        $builder
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('country', CountryType::class, [
                'placeholder' => 'Choix du pays',
                'label' => 'Choix du pays',
            ])
            ->add('dateNaissance', BirthdayType::class, [
                'attr' => array('class' => 'datepickerBirthday'),
                'widget' => 'single_text',
                'label' => 'Date de naissance',
                'format' => 'dd/MM/yyyy',
            ])
            ->add('tarifReduit', CheckboxType::class, [
                'label' => 'Tarif réduit *',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ticket::class,
        ]);
    }
}
