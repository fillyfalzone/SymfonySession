<?php

namespace App\Controller;

use App\Entity\Program;
use App\Entity\Session;
use App\Entity\Student;
use App\Form\SessionType;
use App\Repository\CategoryRepository;
use App\Repository\ModuleRepository;
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
    #[Route('/training/{trainingId}/session/{sessionId}/edit', name: 'edit_session')]
    public function new_edit($trainingId, Request $request, Session $session = null, EntityManagerInterface $entityManager, TrainingRepository $trainingRepository) : Response
    {
        if(!$session){
            $session = new Session(); 
        }
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

        return $this->render('session/new_edit.html.twig',[
            'form' => $form,
            'sessionId' => $session->getId()
        ]);
    }
    /*
        *Delete session
    */

    #[Route('/training/{trainingId}/session/{sessionId}/detele', name: 'delete_session')]
    public function delete(Session $session = null, EntityManagerInterface $entityManager) : Response
    {   
        // On recupere l'id Training de la session à supprimer pour une bonne redirection 
        $training = $session->getTraining();

        $entityManager->remove($session);
        $entityManager->flush();
        
        return $this->redirectToRoute('show_training', ['id' => $training->getId() ]);
    }

    /*
        *Show details of Session
    */
    #[Route('/training/{trainingId}/session/{sessionId}', name: 'show_session')]
    public function show($trainingId, $sessionId, Session $session = null, SessionRepository $sessionRepository, ProgramRepository $programRepository, ModuleRepository $moduleRepository, CategoryRepository $categoryRepository) : Response
    {   
        
        $session = $sessionRepository->find($sessionId);
        
        $studentsInSession = $session->getStudents(); 
        
        // on va recupérer les programmes (Modules, Categorie) de la session afficher. 
        $programs = $programRepository->findBy(['session' => $sessionId]);
        
        foreach ( $programs as $program) {
            $moduleId =  $program->getModules();
            $modules = $moduleRepository->findBy(['id' => $moduleId], ['category' => 'ASC']);
        }



        return $this->render('session/show.html.twig', [
            'session' => $session,
            'modules' => $modules,
            'studentsInSession' => $studentsInSession,
            'programs' => $programs,
            'trainingId' => $trainingId
        ]);
    }

    /*
        * Show Program of current session
    */



   
}
