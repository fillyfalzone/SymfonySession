<?php

namespace App\Controller;

use App\Entity\Session;
use App\Form\SessionType;
use App\Repository\SessionRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SessionController extends AbstractController
{
    #[Route('/session', name: 'app_session')]
    public function index(SessionRepository $sessionRepository): Response
    {   
        $sessios = $sessionRepository->findBy([], ['startDate' => 'ASC']);

        return $this->render('session/index.html.twig', [
            'sessions' => $sessios
        ]);
    }

    #[Route('/session/new/{trainingId}', name: 'new_session')]
    #[Route('/session/{id}/edit', name: 'edit_session')]
    public function new_edit($trainingId, Request $request, Session $session = null, EntityManagerInterface $entityManager, TrainingRepository $trainingRepository) : Response
    {
        if(!$session){
            $session = new Session(); 
        }
        $form = $this->createForm(SessionType::class,$session);
        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $session = $form->getData();
            //a ce niveau le champs training du formulaire est vide 
            // on va recupérer le training correspondant en bd et le set dans l'entité session 
            $training = $trainingRepository->find($trainingId);
            $session->setTraining($training);

            $entityManager->persist($session);
            $entityManager->flush();

            return $this->redirectToRoute('show_training', ['id' => $id]);
        }

        return $this->render('session/new_edit.html.twig',[
            'form' => $form,
            'sessionId' => $session->getId()
        ]);
    }

    #[Route('/session/{id}/delete', name: 'delete_session')]
    public function delete(Session $session, EntityManagerInterface $entityManager) : Response
    {   
        // On recupere l'id Training de la session à supprimer pour une bonne redirection 
        $training = $session->getTraining();

        $entityManager->remove($session);
        $entityManager->flush();
        
        return $this->redirectToRoute('show_training', ['id' => $training->getId() ]);
    }

    #[Route('/session/{id}', name: 'show_session')]
    public function show(Session $session) : Response
    {
        return $this->render('session/show.html.twig', [
            'session' => $session,
        ]);
    }
}
