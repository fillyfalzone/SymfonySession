<?php

namespace App\Form;

use App\Entity\Student;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentSessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('students', EntityType::class, [
            'class' => Student::class,
            'expanded' => true,
            'multiple' => true,
            'group_by' => function (Student $student) {
                // Cette fonction détermine comment les entités sont groupées
                // Dans ce cas, nous les groupons par la première lettre de leur nom
                return substr($student->getLastname(), 0, 1);
            },
            'query_builder' => function (EntityRepository $er) {
                // Utilisez query_builder pour trier les entités par ordre alphabétique
                return $er->createQueryBuilder('s')
                    ->orderBy('s.lastname', 'ASC');
            },
            'attr' => ['style' => 'width:fit-content;']
        ])
        ->add('Submit', SubmitType::class, [
            'attr' => ['class' => 'btn btn-success px-5 rounded-pill m-3']
        ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
