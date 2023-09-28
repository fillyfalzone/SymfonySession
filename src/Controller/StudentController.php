<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Student;
use App\Form\StudentType;
use App\Repository\StudentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentController extends AbstractController
{
    #[Route('/student', name: 'app_student')]
    public function index(StudentRepository $studentRepository): Response
    {   

        return $this->render('student/index.html.twig', [
            
        ]);
    }

    #[Route('/student/new', name: 'new_student')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StudentType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();
            $entityManager->persist($student);
            $entityManager->flush();
            return $this->redirectToRoute('app_student');
        }

        return $this->render('student/new.html.twig', [
            'formAddStudent' => $form->createView()
        ]);
    }


    #[Route('/student/{id}/edit', name: 'edit_student')]
    public function edit(Request $request, Student $student = null, EntityManagerInterface $entityManager) : Response
    {

        $form = $this->createForm(StudentType::class,$student);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();

            $entityManager->persist($student);
            $entityManager->flush();

            return $this->redirectToRoute('app_student');
        }

        return $this->render('student/edit.html.twig',[
            'formEditStudentForm' => $form
        ]);
    }

    #[Route('/student/{id}/delete', name: 'delete_student')]
    public function delete(Student $student, EntityManagerInterface $entityManager) : Response
    {   
        $entityManager->remove($student);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_student');
    }

    #[Route('/student/{id}', name: 'show_student')]
    public function show(Student $student) : Response
    {
        return $this->render('student/show.html.twig', [
            'student' => $student,
        ]);
    }
}
