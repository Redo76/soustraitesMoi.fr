<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Service\UploaderHelper;
use App\Repository\ProjectRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/', name: 'app_project_index', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        // LIER USER/PROJECT:
        // déclarer $user= info class user avec le get
        // déclarer $projects comme objet du tableau project
        // puis rappeler la fonction findAllByUserId en mettant en paramètre user
        $user=$this->getUser();
        $projects=$projectRepository->findAll();
        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAllByUserId($user),
        ]);
    }

    #[Route('/new', name: 'app_project_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectRepository $projectRepository): Response
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

        return $this->renderForm('project/new.html.twig', [
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