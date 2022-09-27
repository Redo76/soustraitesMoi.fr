<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffresController extends AbstractController
{
    #[Route('/offres', name: 'app_offres')]
    public function index(): Response
    {
        return $this->render('offres/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }
}
