<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Webhook;
use App\Service\VivaWallet;
use App\Service\StripePayment;
use App\Repository\AddressRepository;
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
    public function payment(int $id, string $type, AddressRepository $addressRepository, MailerInterface $mailer, ProjectRepository $projectRepository, ProjectLogoRepository $projectLogoRepository, ProjectReseauxRepository $projectReseauxRepository, ProjectSiteRepository $projectSiteRepository)
    {
        $stripe_secret = $this->getParameter('STRIPE_SECRET');
        $payment = new StripePayment($stripe_secret);

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

        // dd($address);
        $session = $payment->startPayment($project);

        return new RedirectResponse($session->url);
    }

    #[Route('/webhook/stripe', name: 'webhook_stripe', methods: ['GET', 'POST'])]
    public function webhookStripe()
    { 

        $stripe_secret = $this->getParameter('STRIPE_SECRET');
        \Stripe\Stripe::setApiKey($stripe_secret);
        
        $endpoint_secret = $this->getParameter('STRIPE_WEBHOOK');

        $payload = file_get_contents('php://input');
        dd($payload);
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $session = $event->data->object;
                dump($event->data->object);
            case 'checkout.session.expired':
                $session = $event->data->object;
                dump($event->data->object);
            case 'customer.created':
                $customer = $event->data->object;
                dump($event->data->object);
            case 'invoice.paid':
                $invoice = $event->data->object;
                dump($event->data->object);
            case 'invoice.payment_failed':
                $invoice = $event->data->object;
                dump($event->data->object);
            // ... handle other event types
            default:
              echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }
}
