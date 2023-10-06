<?php

namespace App\Controller;

use App\Entity\Session;
use App\Entity\Student;
use App\Form\SessionType;
use App\Repository\ProgramRepository;
use App\Repository\SessionRepository;
use App\Repository\StudentRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{

    /*
        * Session list
    */
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {   
        $sessions = $sessionRepository->findBy([], ['startDate' => 'ASC']);

        return $this->render('session/index.html.twig', [
            'sessions' => $sessions
        ]);
    }
    /*
        *Add ou Edit session
    */
    #[Route('/training/{trainingId}/session/new', name: 'new_session')]
    public function new($trainingId, Request $request, Session $session = null, EntityManagerInterface $entityManager, TrainingRepository $trainingRepository) : Response
    {

        $session = new Session(); 
      
        $form = $this->createForm(SessionType::class,$session);
        $form->handleRequest($request);
       
        // On souhaite avoir l'id de trainins 

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
           
            //a ce niveau le champs training du formulaire est vide 
            // on va recupérer le training correspondant en bd et le set dans l'entité session 
            $training = $trainingRepository->find($trainingId);
            $session->setTraining($training);

            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('show_training', ['id' => $trainingId]);
        }

        return $this->render('session/new.html.twig',[
            'form' => $form,
            'sessionId' => $session->getId()
        ]);
    }

    /*
        *Add ou Edit session
    */

    #[Route('/training/{trainingId}/session/{sessionId}/edit', name: 'edit_session')]
    public function edit($trainingId, $sessionId, Request $request, Session $session = null, EntityManagerInterface $entityManager, TrainingRepository $trainingRepository, SessionRepository $sessionRepository) : Response
    {
        $session = $sessionRepository->find($sessionId);

        $form = $this->createForm(SessionType::class,$session);
        $form->handleRequest($request);
       
        // On souhaite avoir l'id de trainins 

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
           
            //a ce niveau le champs training du formulaire est vide 
            // on va recupérer le training correspondant en bd et le set dans l'entité session 
            $training = $trainingRepository->find($trainingId);
            $session->setTraining($training);

            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('show_training', ['id' => $trainingId]);
        }

        return $this->render('session/edit.html.twig',[
            'form' => $form,
            'sessionId' => $trainingId
        ]);
    }
    /*
        *Delete session
    */

    #[Route('/training/{trainingId}/session/{sessionId}/detele', name: 'delete_session')]
    public function delete($trainingId, $sessionId, Session $session = null, EntityManagerInterface $entityManager, SessionRepository $sessionRepository) : Response
    {   
       
        $session = $sessionRepository->find($sessionId);

        $entityManager->remove($session);
        $entityManager->flush();
        
        return $this->redirectToRoute('show_training', ['id' => $trainingId ]);
    }

    /*
        *Show details of Session
    */
    #[Route('/training/{trainingId}/session/{sessionId}', name: 'show_session')]
    public function show($trainingId, $sessionId, Session $session = null, SessionRepository $sessionRepository, ProgramRepository $programRepository) : Response
    {   
        
        $session = $sessionRepository->find($sessionId);
        
        $studentsInSession = $session->getStudents(); 
        
        // on va recupérer les programmes (Modules, Categorie) de la session afficher. 
        $programs = $programRepository->findBy(['session' => $sessionId]);

        // On va afficher les students qui ne sont pas de la session.
        $studentsNotInSession = $sessionRepository->findByStudentsNotInSession($sessionId);
        

        
        return $this->render('session/show.html.twig', [
            'session' => $session,
            'programs' => $programs,
            'studentsInSession' => $studentsInSession,
            'studentsNotInSession' => $studentsNotInSession,
            'trainingId' => $trainingId
        ]);
    }

    #[Route('/training/{trainingId}/session/{sessionId}/student/{studentId}/add', name: 'addStudentInSession_session')]
    public function addStudentInSession($sessionId, $studentId, $trainingId, SessionRepository $sessionRepository, StudentRepository $studentRepository, EntityManagerInterface $entityManager ) : Response
    {
        // On recupère la session concerné en bd
        $session = $sessionRepository->find($sessionId);
        
        // On recupère le student aussi
        $student = $studentRepository->find($studentId);
   
        // On ajoute le student à la session
        $session->addStudent($student); 

        $entityManager->persist($session);
        $entityManager->flush();

        //on redirige vers la page de la session
        return $this->redirectToRoute('show_session', ['trainingId' => $trainingId, 'sessionId' => $sessionId ]);

    }
   
}
