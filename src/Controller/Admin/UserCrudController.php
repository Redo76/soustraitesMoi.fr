<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin/utilisateurs')]
class UserCrudController extends AbstractController
{
    #[Route('/client', name: 'app_admin_client', methods: ['GET'])]
    public function indexClient(UserRepository $userRepository): Response
    {
        $role = "ROLE_CLIENT";

        return $this->render('admin/users.html.twig', [
            'users' => $userRepository->findUsersByRole($role),
        ]);
    }

    #[Route('/expert', name: 'app_admin_expert', methods: ['GET'])]
    public function indexExpert(UserRepository $userRepository): Response
    {
        $roles = "ROLE_EXPERT";

        return $this->render('admin/users.html.twig', [
            'users' => $userRepository->findUsersByRole($roles),
        ]);
    }
}
