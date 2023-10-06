<?php

namespace App\Controller;

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
        $students = $studentRepository->findBy([], ['lastname' => 'ASC']);

        return $this->render('student/index.html.twig', [
            'students' => $students
        ]);
    }

    #[Route('/student/{id}/edit', name: 'edit_student')]
    #[Route('/student/new', name: 'new_student')]
    public function new_edit(Student $student = null, Request $request,EntityManagerInterface $entityManager): Response
    {   
        if(empty($student)) {

            $student = new Student();
        }

        $form = $this->createForm(StudentType::class, $student);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $student = $form->getData();

        
            $entityManager->persist($student);
            $entityManager->flush();
            return $this->redirectToRoute('app_student');
        }

        return $this->render('student/new_edit.html.twig', [
            'form' => $form,
            'studentId' => $student->getId()
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
        $sessions = $student->getSessions();

        $age = $this->calculateAge($student->getBirthDate());

        
        return $this->render('student/show.html.twig', [
            'student' => $student,
            'sessions' => $sessions,
            'age' => $age
        ]);
    }

    public function calculateAge($birthDate)
    {
        $now = new \DateTime();
        $age = $now->diff($birthDate)->format('%Y');

        return $age;
    }
}
