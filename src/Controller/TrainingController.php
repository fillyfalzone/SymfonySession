<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\TrainingType;
use App\Repository\SessionRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrainingController extends AbstractController
{
    #[Route('/training', name: 'app_training')]
    public function index(TrainingRepository $trainingRepository): Response
    {
        $trainings = $trainingRepository->findBy([], ['name' => 'ASC']);

        return $this->render('training/index.html.twig', [
            'trainings' => $trainings,
        ]);
    }

    #[Route('/training/{id}/edit', name: 'edit_training')]
    #[Route('/training/new', name: 'new_training')]
    public function new_edit(Training $training = null, Request $Request, EntityManagerInterface $entityManager ): Response
    {   
        if(!$training){
            $training = new Training();
        }
       
        // Create form by TrainingType to add new training 
        $form = $this->createForm(TrainingType::class, $training);
        // manage form in relation with de enter request 
        $form->handleRequest($Request);

        // If form is successful submit and valid 
        if ($form->isSubmitted() && $form->isValid()){

            // get form data and put it into $training
            $training = $form->getData();
            //prepare 
            $entityManager->persist($training);
            // execute 
            $entityManager->flush();
            // redirect to training list page
            return $this->redirectToRoute('app_training');
        }
        
        return $this->render('training/new_edit.html.twig', [
            'form' => $form,
            'trainingId' => $training->getId()
        ]);
    }


    #[Route('/training/{id}/delete', name: 'delete_training')]
    public function delete(Training $training, EntityManagerInterface $entityManager) : Response 
    {
        $entityManager->remove($training);
        $entityManager->flush();

        return $this->redirectToRoute('app_training');
    }

    #[Route('/training/{id}', name: 'show_training')]
    public function show($id, Training $training, SessionRepository $sessionRepository ) : Response
    {   
        $sessions = $sessionRepository->findBy(['training' => $id], ['name' => 'ASC']);

        return $this->render('training/show.html.twig', [
            'training' => $training,
            'sessions' => $sessions
        ]);
    }
}
