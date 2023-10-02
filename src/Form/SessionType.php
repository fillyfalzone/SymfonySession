<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Student;
use App\Entity\Training;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['class' => 'form-control mb-2'] 
            ])
            ->add('startDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control mb-2'] 
            ])
            ->add('endDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control mb-2']
                ])
            ->add('numberOfPlaces', NumberType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('training', EntityType::class, [
                'class' => Training::class,
                'placeholder' => 'Select a training',
                'attr' => ['class' => 'form-control']
            ])
            ->add('programs', CollectionType::class, [
                'attr' => ['class' => 'form-control, m-2'],
                // la collection attend l'élément quelle entrera dans le form, 
                // ce n'est pas obligatoire que ce soit un autre form
                'entry_type' => ProgramType::class,
                'prototype' => true,
                // on va autoriser l'ajout d'un nouvel élément dans Session qui seront persisté grace au cascade_persist sur l'élément Program.
                // ca va activer un data prototype qui sera un attribut qu'on pourra manipuler en JS.
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false, // obligatoire car on a pas de setProgram dans lentité Session. mais c'est Program qui contient setSession car propriétaire de la relation. pour eviter un mapping false on est obliger de rajouter un by_reference => false,
                
            ])
            ->add('Submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success m-2']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
