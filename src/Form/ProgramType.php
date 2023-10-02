<?php

namespace App\Form;

use App\Entity\Module;
use App\Entity\Program;
use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class ProgramType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('session', HiddenType::class)
        ->add('modules', EntityType::class, [
            'class' => Module::class,
            'attr' => ['class' => ' m-2'],
            // 'multiple' => true, // Permet la sélection de plusieurs stagiaires
            // 'expanded' => false, // Utilisez des cases à cocher
            ])
       
        ->add('numberOfDays', NumberType::class, [
            'attr' => ['class' => 'form-control m-2',
                       'min' => '1', 'max' => '20']
        ]);
     
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Program::class,
        ]);
    }
}
