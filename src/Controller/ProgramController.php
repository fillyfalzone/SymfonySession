<?php

namespace App\Controller;

use App\Entity\Program;
use App\Form\ProgramType;
use App\Repository\ProgramRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProgramController extends AbstractController
{
    #[Route('/program', name: 'app_program')]
    public function index(ProgramRepository $programRepository): Response
    {   
        $programs = $programRepository->findAll();
        

        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    #[Route('/program/new', name: 'new_program')]
    #[Route('/program/{id}/edit', name: 'edit_program')]
    public function new_edit(Program $program = null, Request $Request, EntityManagerInterface $entityManager) : Response
    {
        if (!$program){

            $program = new Program();
        }

        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($Request);
      
        if($form->isSubmitted() && $form->isValid()){

            $program = $form->getData();
           
            $entityManager->persist($program);
            $entityManager->flush();

            return $this->redirectToRoute('app_program');
        }

        return $this->render('program/new.html.twig', [
            'formAddProgram' => $form->createView(),
             'edit' => $program->getId()
        ]);
    }

    #[Route('/program/{id}/delete', name: 'delete_program')]
    public function delete(Program $program, EntityManagerInterface $entityManager) : Response
    {
        $entityManager->remove($program);
        $entityManager->flush();

        return $this->redirectToRoute('app_program');
    }
    
}
