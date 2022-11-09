<?php

namespace App\Service;

use App\Repository\AddressRepository;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;

class StripePayment
{

    public function __construct(readonly private string $clientSecret, readonly private string $webhookSecret = "")
    {
        Stripe::setApiKey($this->clientSecret);
        Stripe::setApiVersion("2022-08-01");
    }

	public function startPayment($project, $user){
		$projectId = $project->getId();
		$projectType = $project->getType();
		$price = $project->getPrice()*100;

		$session = Session::create([
			"mode" => "payment",
			'line_items' => [
				[
					'quantity' => 1,
					'price_data' => [
						'currency' => 'EUR',
						'product_data' => [
							'name' => $project->getNomDuProjet(),
						],
						'unit_amount' => $price,
					],
				],
			],
			"customer_email" => $user->getEmail(),
			"success_url" => "http://localhost:8000/payment/success?session_id={CHECKOUT_SESSION_ID}",
			"cancel_url" => "http://localhost:8000/payment/annulation",
			"billing_address_collection" => "required",
			'metadata' => [
				'project_id' => $projectId,
				'project_type' => $projectType,
				'project_name' => $project->getNomDuProjet(),
			]
		]);

		return $session;
	}

	public function findEvent($eventId)
    {
        return \Stripe\Checkout\Session::retrieve($eventId);
    }
}