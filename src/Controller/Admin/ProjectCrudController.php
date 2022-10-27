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
    #[Route('/', name: 'app_admin_projects', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function indexAll(ProjectRepository $projectRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $projects = $projectRepository->findAllProjects();

        $projectsPagination = $paginator->paginate(
            $projects, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );
        return $this->render('admin/valid_projects.html.twig', [
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
            ->htmlTemplate('emails/project_accepted.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'user' => $user,
                'projectName' => $project->getNomDuProjet(),
            ]);
            
            $mailer->send($email);
            
        $project->setStatut(1);

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
            $route = 'app_admin_projects';
        }else {
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
}