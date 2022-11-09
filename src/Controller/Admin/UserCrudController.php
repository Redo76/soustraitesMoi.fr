<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\SearchProjectType;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/utilisateurs')]
#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractController
{
    #[Route('/client', name: 'app_admin_client', methods: ['GET', 'POST'])]
    public function indexClient(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(SearchProjectType::class);
        $search = $form->handleRequest($request);

        $role = "ROLE_CLIENT";
        $users = $userRepository->findUsersByRole($role);

        if ($search->get('mots')->getdata()!="") {
            // on recherche les IP Projects correspondant aux mots clés saisis
                $users = $userRepository->searchClient($search->get('mots')->getData(),$role);
        }

        $usersPagination = $paginator->paginate(
            $users, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/users.html.twig', [
            'users' => $usersPagination,
            'roleTitle' => "Client", 
            'form' => $form->createView()
        ]);
    }

    #[Route('/expert', name: 'app_admin_expert', methods: ['GET', 'POST'])]
    public function indexExpert(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $form = $this->createForm(SearchProjectType::class);
        $search = $form->handleRequest($request);

        $role = "ROLE_EXPERT";
        $users = $userRepository->findUsersByRole($role);

        if ($search->get('mots')->getdata()!="") {
            // on recherche les IP Projects correspondant aux mots clés saisis
            $users = $userRepository->searchClient($search->get('mots')->getData(),$role);
        }

        $usersPagination = $paginator->paginate(
            $users, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/users.html.twig', [
            'users' => $usersPagination,
            'roleTitle' => "Expert",
            'form' => $form->createView()
        ]);
    }

    
    #[Route('/delete_{id}', name: 'admin_user_delete', methods: ['GET'])]
    public function delete(int $id, UserRepository $userRepository): Response
    {
        $user = $userRepository->findUserById($id);
        $role = $user->getRoles()[0];
        if ($role == "ROLE_CLIENT") {
            $route = 'app_admin_client';
        } elseif ($role == "ROLE_EXPERT") {
            $route = 'app_admin_expert';
        }
        
        $userRepository->remove($user, true);
        
        return $this->redirectToRoute($route, [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}', name: 'app_admin_show', methods: ['GET'])]
    public function show(Request $request, User $user, UserRepository $userRepository): Response
    {
        $role = $user->getRoles()[0];
        if ($role == "ROLE_CLIENT") {
            $profil = "profil_client";
        } elseif ($role == "ROLE_EXPERT") {
            $profil = "profil_expert";
        }
        
        return $this->render($profil .'/show.html.twig', [
            'user' => $user,
        ]);
    }
}
