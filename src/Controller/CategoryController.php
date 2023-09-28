<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/category', name: 'app_category')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findBy([], ['name' => 'ASC']);

        return $this->render('category/index.html.twig', [
            'Categories' => $categories,
        ]);
    }

    

    #[Route('/category/new', name: 'new_category')]
    public function new(Category $category = null, Request $Request, EntityManagerInterface $entityManager ): Response
    {   
        // Create a new category object
        $category = new Category();

        // Create form by CategoryType to add new category 
        $form = $this->createForm(CategoryType::class, $category);
        // manage form in relation with de enter request 
        $form->handleRequest($Request);

        // If form is successful submit and valid 
        if ($form->isSubmitted() && $form->isValid()){

            // get form data and put it into $category
            $category = $form->getData();
            //prepare 
            $entityManager->persist($category);
            // execute 
            $entityManager->flush();
            // redirect to category list page
            return $this->redirectToRoute('app_category');
        }
        
        return $this->render('category/new.html.twig', [
            'formAddCategory' => $form
        ]);
    }

    #[Route('/category/{id}/edit', name: 'edit_category')]
    public function edit(Category $category = null, Request $Request, EntityManagerInterface $entityManager) : Response
    {   
        // Create form by CategoryType to add new category 
        $form = $this->createForm(CategoryType::class, $category);
        // manage form in relation with de enter request 
        $form->handleRequest($Request);

        // If form is successful submit and valid 
        if ($form->isSubmitted() && $form->isValid()){

            // get form data and put it into $category
            $category = $form->getData();
            //prepare 
            $entityManager->persist($category);
            // execute 
            $entityManager->flush();
            // redirect to category list page
            return $this->redirectToRoute('app_category');
        }

        return $this->render('category/edit.html.twig', [
            'formEditCategory' => $form,
        ]);
    }


    #[Route('/category/{id}/delete', name: 'delete_category')]
    public function delete(Category $category, EntityManagerInterface $entityManager) : Response
    {   
        $entityManager->remove($category);
        $entityManager->flush();
        
        return $this->redirectToRoute('app_category');
    }


    #[Route('/category/{id}', name: 'show_category')]
    public function show(Category $category) : Response
    {
        return $this->render('category/show.html.twig', [
            'category' => $category,
        ]);
    }
}
