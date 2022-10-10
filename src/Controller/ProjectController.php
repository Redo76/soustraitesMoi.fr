<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\ProjectLogo;
use App\Form\ProjectLogoType;
use App\Entity\ProjectReseaux;
use App\Service\UploaderHelper;
use App\Form\ProjectReseauxType;
use App\Repository\ProjectRepository;
use App\Repository\ProjectLogoRepository;
use App\Repository\ProjectReseauxRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository): Response
    {
        // LIER USER/PROJECT:
        // déclarer $user= info class user avec le get
        // déclarer $projects comme objet du tableau project
        // puis rappeler la fonction findAllByUserId en mettant en paramètre user
        $user=$this->getUser();
        // $projects=$projectRepository->findAll();
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAllByUserId($user),
            'projectsLogo' => $projectLogoRepository->findAllByUserId($user),
        ]);
    }

    #[Route('/nouveau', name: 'app_project_new', methods: ['GET'])]
    public function new(): Response
    {
        return $this->render('project/new.html.twig', [
            'controller_name' => 'ProjectController',
        ]);
    }

    #[Route('/libre', name: 'app_project_free', methods: ['GET', 'POST'])]
    public function freeProject(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectRepository $projectRepository): Response
    {
        $project = new Project($this->getUser());
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form['Images']->getData();

            if ($uploadedFiles) {
                foreach ($uploadedFiles as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $project->addImage($img);
                }
            }

            $projectRepository->add($project, true);

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/project_libre.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/logo', name: 'app_project_logo', methods: ['GET', 'POST'])]
    public function logoProject(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectLogoRepository $projectLogoRepository): Response
    {
        $project = new ProjectLogo($this->getUser());
        $form = $this->createForm(ProjectLogoType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles1 = $form['good_logo_example']->getData();
            $uploadedFiles2 = $form['bad_logo_example']->getData();

            if ($uploadedFiles1) {
                foreach ($uploadedFiles1 as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $project->addGoodLogoExample($img);
                }
            }

            if ($uploadedFiles2) {
                foreach ($uploadedFiles2 as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $project->addBadLogoExample($img);
                }
            }

            $projectLogoRepository->add($project, true);

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/project_logo.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/réseaux-sociaux', name: 'app_project_reseaux', methods: ['GET', 'POST'])]
    public function reseauxProject(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectReseauxRepository $projectReseauxRepository): Response
    {
        $project = new ProjectReseaux($this->getUser());
        $form = $this->createForm(ProjectReseauxType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles1 = $form['logo']->getData();
            $uploadedFiles2 = $form['example']->getData();

            if ($uploadedFiles1) {
                foreach ($uploadedFiles1 as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $project->addLogo($img);
                }
            }

            if ($uploadedFiles2) {
                foreach ($uploadedFiles2 as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $project->addExample($img);
                }
            }

            $projectReseauxRepository->add($project, true);

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/project_reseaux.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('project/show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_project_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, Project $project, ProjectRepository $projectRepository): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles = $form['Images']->getData();

            if ($uploadedFiles) {
                foreach ($uploadedFiles as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $project->addImage($img);
                }
            }
            $projectRepository->add($project, true);

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_project_delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, ProjectRepository $projectRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->request->get('_token'))) {
            $projectRepository->remove($project, true);
        }

        return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
    }
}