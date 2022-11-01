<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Entity\ProjectLogo;
use App\Repository\UserRepository;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ProjectLogoRepository;
use App\Repository\ProjectSiteRepository;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\ProjectReseauxRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/admin/projets')]
class ProjectCrudController extends AbstractController
{
    #[Route('/valides', name: 'app_admin_validProjects', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function indexAllValid(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAllValidProjects();
    
        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/valid_projects.html.twig', [
            'projects' => $projectsPagination,
        ]);
    }

    #[Route('/acceptés', name: 'app_admin_projects', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function indexAll(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAllProjects();

        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/accepted_projects.html.twig', [
            'projects' => $projectsPagination,
        ]);
    }

    #[Route('/en-cours', name: 'app_admin_IpProjects', methods: ['GET'])]
    public function indexIP(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAllInProgressProjects();
        // dd($projects);

        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/in-progress_projects.html.twig', [
            'projects' => $projectsPagination,
        ]);
    }

    #[Route('/validate_{id}&{type}', name: 'admin_project_validate', methods: ['GET'])]
    public function validate(int $id, string $type, EntityManagerInterface $entityManager, MailerInterface $mailer,UserRepository $userRepository, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository): Response
    {
        $type = ["type" => $type]["type"];
        if ($type == "Libre") {
            $project = $projectRepository->find(["id" => $id]);
        } elseif ($type == "Logo") {
            $project = $projectLogoRepository->find(["id" => $id]);
        } elseif ($type == "Réseaux Sociaux") {
            $project = $projectReseauxRepository->find(["id" => $id]);
        } elseif ($type == "Site Internet") {
            $project = $projectSiteRepository->find(["id" => $id]);
        }

        $userId = $project->getUser()->getId();
        $user = $userRepository->findUserById($userId);
        $email = (new TemplatedEmail())
            ->from('soustraitesmoi@gmail.com')
            ->to($user->getEmail())
            ->subject('Validation de votre projet')
            ->htmlTemplate('emails/project_validated.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'user' => $user,
                'projectName' => $project->getNomDuProjet(),
            ]);
            
            $mailer->send($email);
            
        $project->setStatut(1);

        $entityManager->persist($project);
        $entityManager->flush();
                
        return $this->redirectToRoute('app_admin_projects', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/accept_{id}&{type}', name: 'admin_project_accept', methods: ['GET'])]
    public function accept(int $id, string $type, EntityManagerInterface $entityManager, MailerInterface $mailer,UserRepository $userRepository, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository): Response
    {
        $type = ["type" => $type]["type"];
        if ($type == "Libre") {
            $project = $projectRepository->find(["id" => $id]);
        } elseif ($type == "Logo") {
            $project = $projectLogoRepository->find(["id" => $id]);
        } elseif ($type == "Réseaux Sociaux") {
            $project = $projectReseauxRepository->find(["id" => $id]);
        } elseif ($type == "Site Internet") {
            $project = $projectSiteRepository->find(["id" => $id]);
        }

        $userId = $project->getUser()->getId();
        $user = $userRepository->findUserById($userId);
        $email = (new TemplatedEmail())
            ->from('soustraitesmoi@gmail.com')
            ->to($user->getEmail())
            ->subject('Acceptation de votre projet')
            ->htmlTemplate('emails/project_accepted.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'user' => $user,
                'projectName' => $project->getNomDuProjet(),
            ]);
            
            $mailer->send($email);
            
        $project->setStatut(0);

        $entityManager->persist($project);
        $entityManager->flush();
                
        return $this->redirectToRoute('app_admin_IpProjects', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete_{id}&{type}', name: 'admin_project_delete', methods: ['GET'])]
    public function delete(int $id, string $type, MailerInterface $mailer,UserRepository $userRepository, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository): Response
    {
        $type = ["type" => $type]["type"];
        if ($type == "Libre") {
            $project = $projectRepository->find(["id" => $id]);
            $repository = $projectRepository;
        } elseif ($type == "Logo") {
            $project = $projectLogoRepository->find(["id" => $id]);
            $repository = $projectLogoRepository;
        } elseif ($type == "Réseaux Sociaux") {
            $project = $projectReseauxRepository->find(["id" => $id]);
            $repository = $projectReseauxRepository;
        } elseif ($type == "Site Internet") {
            $project = $projectSiteRepository->find(["id" => $id]);
            $repository = $projectSiteRepository;
        }

        if ($project->getStatut() == true) {
            $route = 'app_admin_validProjects';
        } elseif ($project->getStatut() == false) {
            $route = 'app_admin_projects';
        } else {
            $route = 'app_admin_IpProjects';

            $userId = $project->getUser()->getId();
            $user = $userRepository->findUserById($userId);
            $email = (new TemplatedEmail())
                ->from('soustraitesmoi@gmail.com')
                ->to($user->getEmail())
                ->subject('Suppression de votre projet')
                ->htmlTemplate('emails/project_denied.html.twig')
    
                // pass variables (name => value) to the template
                ->context([
                    'user' => $user,
                    'projectName' => $project->getNomDuProjet(),
                ]);
                
            $mailer->send($email);
        }
            
        $repository->remove($project, true);
                
        return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/relance_{id}&{type}', name: 'admin_project_relance', methods: ['GET'])]
    public function relance(int $id, string $type, EntityManagerInterface $entityManager, MailerInterface $mailer,UserRepository $userRepository, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository): Response
    {
        $type = ["type" => $type]["type"];
        if ($type == "Libre") {
            $project = $projectRepository->find(["id" => $id]);
        } elseif ($type == "Logo") {
            $project = $projectLogoRepository->find(["id" => $id]);
        } elseif ($type == "Réseaux Sociaux") {
            $project = $projectReseauxRepository->find(["id" => $id]);
        } elseif ($type == "Site Internet") {
            $project = $projectSiteRepository->find(["id" => $id]);
        }
        $price = $project->getPrice();

        $userId = $project->getUser()->getId();
        $user = $userRepository->findUserById($userId);
        $email = (new TemplatedEmail())
            ->from('soustraitesmoi@gmail.com')
            ->to($user->getEmail())
            ->subject('Relance de votre projet')
            ->htmlTemplate('emails/project_relance.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'user' => $user,
                'price' => $price,
                'projectName' => $project->getNomDuProjet(),
            ]);
            
        $mailer->send($email);

        $entityManager->persist($project);
        $entityManager->flush();
                
        return $this->redirectToRoute('app_admin_projects', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/price_{id}&{type}', name: 'admin_project_price', methods: ['GET', 'POST'])]
    public function changePrice(int $id, string $type, EntityManagerInterface $entityManager, MailerInterface $mailer,UserRepository $userRepository, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository): Response
    {
        $type = ["type" => $type]["type"];
        if ($type == "Libre") {
            $project = $projectRepository->find(["id" => $id]);
        } elseif ($type == "Logo") {
            $project = $projectLogoRepository->find(["id" => $id]);
        } elseif ($type == "Réseaux Sociaux") {
            $project = $projectReseauxRepository->find(["id" => $id]);
        } elseif ($type == "Site Internet") {
            $project = $projectSiteRepository->find(["id" => $id]);
        }
        $project->setPrice($_POST["price"]);

        $userId = $project->getUser()->getId();
        $user = $userRepository->findUserById($userId);
        $email = (new TemplatedEmail())
            ->from('soustraitesmoi@gmail.com')
            ->to($user->getEmail())
            ->subject('Proposition commerciale pour votre projet')
            ->htmlTemplate('emails/project_offre.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'user' => $user,
                'price' => $_POST["price"],
                'projectName' => $project->getNomDuProjet(),
            ]);
            
        $mailer->send($email);

        $entityManager->persist($project);
        $entityManager->flush();
                
        return $this->redirectToRoute('app_admin_projects', [], Response::HTTP_SEE_OTHER);
    }
}