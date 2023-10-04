<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Student;

use App\Form\StudentSessionType;
use App\Repository\SessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StudentSessionController extends AbstractController
{
    #[Route('/student/session', name: 'app_student_session')]
    public function index(): Response
    {
        return $this->render('student_session/index.html.twig', [
            'controller_name' => 'StudentSessionController',
        ]);
    }

    #[Route('/student/session/{id}', name: 'addStudent_student_session')]
    public function addStudent($id, Request $request, SessionRepository $sessionRepository, EntityManagerInterface $entityManager): Response
    {
        // Récupérez la session en fonction de l'ID
        $session = $sessionRepository->find($id);
        

        //  Vérifiez si la session existe
        if (!$session) {
            throw $this->createNotFoundException('Session not found');
        }

        // Créez le formulaire
        $form = $this->createForm(StudentSessionType::class);

        // Gérez la soumission du formulaire
        $form->handleRequest($request);

        //  Vérifiez si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            //  Récupérez la liste des étudiants sélectionnés à partir du formulaire
            $selectedStudents = $form->get('students')->getData();

            //  Ajoutez chaque étudiant sélectionné à la session
            foreach ($selectedStudents as $student) {
                $session->addStudent($student);
            }

            // Persistez les modifications en base de données
            $entityManager->persist($session);
            $entityManager->flush();

            // Redirigez l'utilisateur vers une page de succès
            return $this->redirectToRoute('show_session', ['id' => $id]);
        }

        //  Affichez le formulaire dans la vue Twig
        return $this->render('student_session/addStudent.html.twig', [
            'form' => $form->createView(),
            'session' => $session,
        ]);
    }

    #[Route('/session/{sessionId}/student/{studentId}/remove', name: 'remove_student_session')]
    public function remove($sessionId, $studentId, EntityManagerInterface $entityManager) : Response 
    {
        $session = $entityManager->getRepository(Session::class)->find($sessionId);
        $student = $entityManager->getRepository(Student::class)->find($studentId);

        if (!$session || !$student) {
            throw $this->createNotFoundException('Session or Student not found');
        }
        // Supprimez l'étudiant de la session
        $session->removeStudent($student);

        // Mettez à jour la base de données
        $entityManager->flush();

        // Redirigez l'utilisateur vers une page de succès ou une autre page appropriée
        return $this->redirectToRoute('show_session', ['id' => $sessionId ]);
    }


}
