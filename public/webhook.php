<?php

use App\Service\StripePayment;
use Symfony\Component\HttpFoundation\Request;

$request = Request::createFromGlobals();
$payment = new StripePayment("sk_test_51Lz0muBYncSfR55nrpsR1uVHAvpX3c9qhILWZJ2RudMpIEQxKjFHup9u1MpB1SXm2DJ2yj5DJ80Qmc9lwIY4YyfR00AGKCfl0X");
$payment->handle($request);
// whsec_df4efeb516c10e0eb350bd44a1f61b10caeb48b7a3988eb37042e152bf617989