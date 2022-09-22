<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentationLegalesController extends AbstractController
{
    #[Route('/mentions-légales', name: 'app_mention_legales')]
    public function index(): Response
    {
        return $this->render('documentation_legales/mentions_légales.html.twig', [
            'controller_name' => 'DocumentationLegalesController',
        ]);
    }
}
