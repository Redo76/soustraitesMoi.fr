<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExpertController extends AbstractController
{
    #[Route('/mon-compte-expert', name: 'app_expert')]
    // #[IsGranted('ROLE_EXPERT')]
    // #[IsGranted('ROLE_ADMIN')]
    public function index(): Response
    {
        return $this->render('profil_expert/index.html.twig', [
            'controller_name' => 'ExpertController',
        ]);
    }
}
