<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/utilisateurs')]
class UserCrudController extends AbstractController
{
    #[Route('/client', name: 'app_admin_client', methods: ['GET'])]
    public function indexClient(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $role = "ROLE_CLIENT";
        $users = $userRepository->findUsersByRole($role);

        $usersPagination = $paginator->paginate(
            $users, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/users.html.twig', [
            'users' => $usersPagination,
            'roleTitle' => "Client",
        ]);
    }

    #[Route('/expert', name: 'app_admin_expert', methods: ['GET'])]
    public function indexExpert(UserRepository $userRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $role = "ROLE_EXPERT";

        $users = $userRepository->findUsersByRole($role);

        $usersPagination = $paginator->paginate(
            $users, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            10 /*limit per page*/
        );

        return $this->render('admin/users.html.twig', [
            'users' => $usersPagination,
            'roleTitle' => "Expert",
        ]);
    }

    #[Route('/{id}', name: 'admin_user_delete', methods: ['GET'])]
    public function delete(Request $request, User $user, UserRepository $userRepository): Response
    {
        dd($user);
        $userRepository->remove($user, true);
        
        return $this->redirectToRoute('app_admin_client', [], Response::HTTP_SEE_OTHER);
    }
}
