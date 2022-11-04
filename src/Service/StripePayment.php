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

	public function startPayment($project){
		$projectId = $project->getId();
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
			"success_url" => "https://fe08-2a01-e0a-8f3-d270-d5a9-596c-cc72-2ad2.eu.ngrok.io/payment/webhook/stripe",
			"cancel_url" => "http://localhost:8000/offres",
			"billing_address_collection" => "required",
			'metadata' => [
				'project_id' => $projectId,
			]
		]);
		$project->setSessionId($session->id);

		return $session;
	}
}