<?php

namespace App\Controller;

use App\Entity\Training;
use App\Form\TrainingType;
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

    #[Route('/training/new', name: 'new_training')]
    public function new(Training $training = null, Request $Request, EntityManagerInterface $entityManager ): Response
    {   
        // Create a new training object
        $training = new Training();

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
        
        return $this->render('training/new.html.twig', [
            'formAddTraining' => $form
        ]);
    }

    #[Route('/training/{id}/edit', name: 'edit_training')]
    public function edit(Training $training, EntityManagerInterface $entityManager, Request $request) : Response
    {
        $form = $this->createForm(Training::class, $training);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $training = $form->getData();

            $entityManager->persist($training);
            $entityManager->flush();

            return $this->redirectToRoute('app_training');
        }

        return $this->render('training/edit.html.twig', [
            'formEditTraining' => $form
        ]);
    }

    #[Route('/training/{id}/delete', name: 'delete_training')]
    public function delete(Training $training, EntityManagerInterface $entityManager) : Response 
    {
        $entityManager->remove($training);
        $entityManager->flush();

        return $this->redirectToRoute('app_trainig');
    }

    #[Route('/training/{id}', name: 'show_training')]
    public function show(Training $training) : Response
    {   

        return $this->render('training/show.html.twig', [
            'training' => $training
        ]);
    }
}
