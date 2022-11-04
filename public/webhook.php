<?php

use App\Service\StripePayment;
use Symfony\Component\HttpFoundation\Request;


$request = Request::createFromGlobals();
$payment = new StripePayment($_ENV["STRIPE_SECRET"], $_ENV["STRIPE_WEBHOOK"]);
$payment->handle($request);
// whsec_df4efeb516c10e0eb350bd44a1f61b10caeb48b7a3988eb37042e152bf617989