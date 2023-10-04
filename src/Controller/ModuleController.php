<?php

namespace App\Controller;

use App\Entity\Module;
use App\Form\ModuleType;
use App\Repository\ModuleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ModuleController extends AbstractController
{
    #[Route('/module', name: 'app_module')]
    public function index(ModuleRepository $moduleRepository): Response
    {   
        $modules = $moduleRepository->findBy([], ['name' => 'ASC']);

        return $this->render('module/index.html.twig', [
            'modules' => $modules,
        ]);
    }

    #[Route('/module/{id}/edit', name: 'edit_module')]
    #[Route('/module/new', name: 'new_module')]
    public function new(Module $module = null, Request $Request, EntityManagerInterface $entityManager ): Response
    {   
        // Create a new module object
        if(!$module){
            $module = new Module();
        }

        // Create form by ModuleType to add new module 
        $form = $this->createForm(ModuleType::class, $module);
        // manage form in relation with de enter request 
        $form->handleRequest($Request);

        // If form is successful submit and valid 
        if ($form->isSubmitted() && $form->isValid()){

            // get form data and put it into $module
            $module = $form->getData();
            //prepare 
            $entityManager->persist($module);
            // execute 
            $entityManager->flush();
            // redirect to module list page
            return $this->redirectToRoute('app_module');
        }
        
        return $this->render('module/new_edit.html.twig', [
            'form' => $form,
            'moduleId' => $module->getId()
        ]);
    }

    

    #[Route('/module/{id}/delete', name: 'delete_module')]
    public function delete(Module $module, EntityManagerInterface $entityManager) : Response 
    {
        $entityManager->remove($module);
        $entityManager->flush();

        return $this->redirectToRoute('app_module');
    }

    #[Route('/module/{id}', name: 'show_module')]
    public function show(Module $module) : Response
    {   

        return $this->render('module/show.html.twig', [
            'module' => $module
        ]);
    }

}

