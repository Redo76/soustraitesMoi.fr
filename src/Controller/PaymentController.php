<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\VivaWallet;
use App\Service\StripePayment;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Kernel;
use App\Repository\ProjectLogoRepository;
use App\Repository\ProjectSiteRepository;
use App\Repository\ProjectReseauxRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\DataTransformer\StringToFileTransformer;

#[Route('/payment')]
class PaymentController extends AbstractController
{
    #[Route('/{id}&{type}', name: 'app_payment', methods: ['GET', 'POST'])]
    public function index(int $id, string $type, EntityManagerInterface $entityManager, MailerInterface $mailer, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository)
    {
        $payment = new StripePayment("sk_test_51Lz0muBYncSfR55nrpsR1uVHAvpX3c9qhILWZJ2RudMpIEQxKjFHup9u1MpB1SXm2DJ2yj5DJ80Qmc9lwIY4YyfR00AGKCfl0X");

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
        // dd($project);

        $session = $payment->startPayment($project);

        return new RedirectResponse($session->url);
    }
}
