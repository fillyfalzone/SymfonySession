<?php

namespace App\Form;

use App\Entity\Session;
use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class StudentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('firstname', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => ['class' => 'form-control']
                ])
            ->add('email', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('phoneNumber', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('street', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('zipCode', TextType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('sessions', EntityType::class, [
                'class' => Session::class,
                'placeholder' => 'Please select session',
                'attr' => ['class' => 'form-control']
                ])
            ->add('Submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-success']
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}
