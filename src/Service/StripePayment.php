<?php

namespace App\Service;

use Stripe\Checkout\Session;
use Stripe\Stripe;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class StripePayment
{

    public function __construct(readonly private string $clientSecret)
    {
        Stripe::setApiKey($this->clientSecret);
        Stripe::setApiVersion("2022-08-01");
    }

	public function startPayment(){
		$session = Session::create([
			"mode" => "payment",
			"success_url" => "http://localhost:8000/",
			"cancel_url" => "http://localhost:8000/offres",
			"billing_address_collection" => "required",
		]);
	}

}