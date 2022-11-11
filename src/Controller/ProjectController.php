<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Project;
use App\Form\ProjectType;
use App\Entity\ProjectLogo;
use App\Entity\ProjectSite;
use App\Form\ProjectLogoType;
use App\Form\ProjectSiteType;
use App\Entity\ProjectReseaux;
use App\Service\UploaderHelper;
use App\Form\ProjectReseauxType;
use App\Repository\ImageRepository;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use App\Repository\ProjectLogoRepository;
use App\Repository\ProjectSiteRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ProjectReseauxRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

#[Route('/project')]
class ProjectController extends AbstractController
{
    #[Route('/mes-projets', name: 'app_project_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $userId = $this->getUser()->getId();
        $projects = $userRepository->findAllProjectsByUserId($userId);

        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('project/index.html.twig', [
            'projects' => $projectsPagination,
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
    public function freeProject(Request $request, Userrepository $userRepository,MailerInterface $mailer, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectRepository $projectRepository): Response
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
            $project->setType("Libre");

            $projectRepository->add($project, true);

            // envoi email
            $userId = $project->getUser()->getId();
            $user = $userRepository->findUserById($userId);
            $email = (new TemplatedEmail())
                ->from($user->getEmail())
                ->to('soustraitesmoi@gmail.com')
                ->subject('Proposition de projet')
                ->htmlTemplate('emails/project_depot.html.twig')
        
                // pass variables (name => value) to the template
                ->context([
                    'user' => $user,
                    'projectName' => $project->getNomDuProjet(),
                ]);
                
                $mailer->send($email);
        
            // message confirmation envoi
            $this->addFlash(
                'success',
                'votre projet a bien été déposé. Après analyse par notre équipe,
                vous recevrez un mail de confirmation'
            );

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/project_libre/project_libre.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/logo', name: 'app_project_logo', methods: ['GET', 'POST'])]
    public function logoProject(Request $request, Userrepository $userRepository,MailerInterface $mailer, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectLogoRepository $projectLogoRepository): Response
    {
        $project = new ProjectLogo($this->getUser());
        $form = $this->createForm(ProjectLogoType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles1 = $form['good_logo_example']->getData();
            $uploadedFiles2 = $form['bad_logo_example']->getData();

            // dd($uploadedFiles2);

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
            $project->setType("Logo");

            $projectLogoRepository->add($project, true);

            // envoi email
            $userId = $project->getUser()->getId();
            $user = $userRepository->findUserById($userId);
            $email = (new TemplatedEmail())
                ->from($user->getEmail())
                ->to('soustraitesmoi@gmail.com')
                ->subject('Proposition de projet')
                ->htmlTemplate('emails/project_depot.html.twig')
        
                // pass variables (name => value) to the template
                ->context([
                    'user' => $user,
                    'projectName' => $project->getNomDuProjet(),
                ]);
                
                $mailer->send($email);
        
            // message confirmation envoi
            $this->addFlash(
                'success',
                'votre projet a bien été déposé. Après analyse par notre équipe,
                vous recevrez un mail de confirmation'
            );

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/project_logo/project_logo.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/réseaux-sociaux', name: 'app_project_reseaux', methods: ['GET', 'POST'])]
    public function reseauxProject(Request $request, Userrepository $userRepository,MailerInterface $mailer, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectReseauxRepository $projectReseauxRepository): Response
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
            $project->setType("Réseaux Sociaux");

            $projectReseauxRepository->add($project, true);

            // envoi email
            $userId = $project->getUser()->getId();
            $user = $userRepository->findUserById($userId);
            $email = (new TemplatedEmail())
                ->from($user->getEmail())
                ->to('soustraitesmoi@gmail.com')
                ->subject('Proposition de projet')
                ->htmlTemplate('emails/project_depot.html.twig')
        
                // pass variables (name => value) to the template
                ->context([
                    'user' => $user,
                    'projectName' => $project->getNomDuProjet(),
                ]);
                
                $mailer->send($email);
        
            // message confirmation envoi
            $this->addFlash(
                'success',
                'votre projet a bien été déposé. Après analyse par notre équipe,
                vous recevrez un mail de confirmation'
            );

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/project_réseaux/project_reseaux.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/site-internet', name: 'app_project_site', methods: ['GET', 'POST'])]
    public function siteProject(Request $request, Userrepository $userRepository,MailerInterface $mailer, SluggerInterface $slugger, UploaderHelper $uploaderHelper, ProjectSiteRepository $projectSiteRepository): Response
    {
        $project = new ProjectSite($this->getUser());
        $form = $this->createForm(ProjectSiteType::class, $project);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFiles1 = $form['logo_files']->getData();
            $uploadedFiles2 = $form['visuals_files']->getData();


            if ($uploadedFiles1) {
                foreach ($uploadedFiles1 as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);

                    $project->addLogoFile($img);
                }
            }

            if ($uploadedFiles2) {
                foreach ($uploadedFiles2 as $key => $uploadedFile) {
                    $newFilename = $uploaderHelper->uploadProjectImages($uploadedFile, $slugger);
                    $img = new Image();
                    $img->setName($newFilename);
                    
                    $project->addVisualsFile($img);
                }
            }
            $project->setType("Site Internet");

            $projectSiteRepository->add($project, true);

            // envoi email
            $userId = $project->getUser()->getId();
            $user = $userRepository->findUserById($userId);
            $email = (new TemplatedEmail())
                ->from($user->getEmail())
                ->to('soustraitesmoi@gmail.com')
                ->subject('Proposition de projet')
                ->htmlTemplate('emails/project_depot.html.twig')
        
                // pass variables (name => value) to the template
                ->context([
                    'user' => $user,
                    'projectName' => $project->getNomDuProjet(),
                ]);
                
                $mailer->send($email);
        
            // message confirmation envoi
            $this->addFlash(
                'success',
                'votre projet a bien été déposé. Après analyse par notre équipe,
                vous recevrez un mail de confirmation'
            );

            return $this->redirectToRoute('app_project_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('project/project_site/project_site.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}&{type}', name: 'app_project_info', methods: ['GET', 'POST'])]
    public function edit(int $id, string $type, ImageRepository $imageRepository, UserRepository $userRepository, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository): Response
    {
        $type = ["type" => $type]["type"];
        if ($type == "Libre") {
            $project = $projectRepository->findOneBy(["id" => $id]);
            $images1 = $imageRepository->findByProjectFree(["id" => $id]);
            $images2 = null;
            $repo = "project_libre";
            // dd($project);
        } elseif ($type == "Logo") {
            $project = $projectLogoRepository->findOneBy(["id" => $id]);
            $images1 = $imageRepository->findByGoodLogo(["id" => $id]);
            $images2 = $imageRepository->findByBadLogo(["id" => $id]);
            $repo = "project_logo";
        } elseif ($type == "Réseaux Sociaux") {
            $project = $projectReseauxRepository->findOneBy(["id" => $id]);
            $images1 = $imageRepository->findByReseauxLogo(["id" => $id]);
            $images2 = $imageRepository->findByReseauxExample(["id" => $id]);
            $repo = "project_réseaux";
            // dd($project);
        } elseif ($type == "Site Internet") {
            $project = $projectSiteRepository->findOneBy(["id" => $id]);
            $images1 = $imageRepository->findByVisuals(["id" => $id]);
            $images2 = $imageRepository->findByLogoSite(["id" => $id]);
            $repo = "project_site";
            // dd($images2);
        }
        // dd($images1);
        // dd($images2);
        // dd($project);

        return $this->render('project/'. $repo . '/project_info.html.twig', [
            'project' => $project,
            'images1' => $images1,
            'images2' => $images2,
        ]);
    }
}