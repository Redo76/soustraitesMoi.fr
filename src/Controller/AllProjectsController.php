<?php

namespace App\Controller;

use App\Entity\ProjectLogo;
use App\Form\ProjectLogoType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AllProjectsController extends AbstractController
{
    #[Route('/tous-les projets', name: 'app_projects')]
    public function index(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAllProjects();

        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('project/projects.html.twig', [
            'projects' => $projectsPagination,
        ]);
    }
    
    #[Route('/test', name: 'test')]
    public function index2(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $project = new ProjectLogo($this->getUser());
        $form = $this->createForm(ProjectLogoType::class, $project);

        return $this->render('project/project_logo/project_info.html.twig', [
            'project' => $project,
        ]);
    }
}

