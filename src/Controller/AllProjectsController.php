<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;


class AllProjectsController extends AbstractController
{
    #[Route('/tous-les projets', name: 'app_projects')]
    public function index(ProjectRepository $projectRepository): Response
    {
        
        return $this->render('project/projects.html.twig', [
            'projects' => $projectRepository->findAllProjects(),
        ]);
    }
}
