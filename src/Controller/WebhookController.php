<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Service\StripePayment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class WebhookController extends AbstractController
{
    // #[Route('/webhook/stripe', name: 'webhook_stripe', methods: ['GET', 'POST'])]
    // public function webhook(Request $request, StripePayment $stripePayment): Response
    // {

    //     $data = json_decode($request->getContent(), true);
    //     if ($data === null) {
    //         throw new \Exception('Requete introuvable de la part de Stripe');
    //     }
    //     $eventId = $data["id"];
    //     $stripeEvent = $stripePayment->findEvent($eventId);

    //     dd($stripeEvent);

    //     switch ($stripeEvent->type) {
    //         case 'checkout.session.completed':
    //             $session = $stripeEvent->data->object;
    //             dump($stripeEvent->data->object);
    //         case 'checkout.session.expired':
    //             $session = $stripeEvent->data->object;
    //             dump($stripeEvent->data->object);
    //         case 'customer.created':
    //             $customer = $stripeEvent->data->object;
    //             dump($stripeEvent->data->object);
    //         case 'invoice.paid':
    //             $customer = $stripeEvent->data->object;
    //             dump($stripeEvent->data->object);
    //         case 'invoice.payment_failed':
    //             $customer = $stripeEvent->data->object;
    //             dump($stripeEvent->data->object);
    //         // ... handle other event types
    //         default:
    //             throw new \Exception('Webhook non défini de la part de Stripe '.$stripeEvent->type);
            
    //         http_response_code(200);
    //     }
    // }
}
