<?php

namespace App\Controller;

use App\Repository\SessionRepository;
use App\Repository\TrainingRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index( TrainingRepository $trainingRepository): Response
    {
        $trainings = $trainingRepository->findBy([], ['name' => 'ASC']);

        return $this->render('home/index.html.twig', [
            'trainings' => $trainings,
        ]);
    }
}
