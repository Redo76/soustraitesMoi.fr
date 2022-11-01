<?php

namespace App\Controller;

use App\Service\StripePayment;
use Stripe\Stripe;
use App\Service\VivaWallet;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use EasyCorp\Bundle\EasyAdminBundle\Form\DataTransformer\StringToFileTransformer;

class PaymentController extends AbstractController
{
    public function index()
    {
        $payment = new StripePayment("sk_test_51Lz0muBYncSfR55nrpsR1uVHAvpX3c9qhILWZJ2RudMpIEQxKjFHup9u1MpB1SXm2DJ2yj5DJ80Qmc9lwIY4YyfR00AGKCfl0X");


        
        return $this->render('payment/native.html.twig', [
            'amount' => $this->amount,
        ]);
    }


    /**
    * Make some transations accordind the "action" value from the form
    **/
    public function submit(Request $request, VivaWallet $viva)
    {       
        $pre_auth = $request->request->get('action') == 'authorization' ? false : true;

        $client = [
            'email' => $request->request->get('email'),
            'phone' => $request->request->get('phone'),
            'full_name' => $request->request->get('name'),
            'request_lang' => 'pt',
            'country_code' => 'PT'
        ];

        $transaction = [
            'amount' => $this->amount,
            'installments' => 1,
            'charge_token' => $request->request->get('token'),
            'merchant_trans' => 'Information to the Merchant',
            'customer_trans' => 'Information to the Client ' .$request->request->get('action'),
            'tip_amount' => 0,
            'pre_auth' => $pre_auth,
            'currency_code' => 978// https://pt.iban.com/currency-codes
        ];

        if($request->request->get('action') == 'charge'){
            $charge = $viva->setCharge($client, $transaction);
            //Something went wrong send info to user
            if ($charge['status'] == 0)
                return new JsonResponse([
                    'status' => 0,
                    'message' => $charge['data'],
                    'data' => $charge
                ]);

            return new JsonResponse([
                'status' => 1,
                'message' => $charge['data'],
                'data' => $trans
            ]);

        }
        
        else if($request->request->get('action') == 'authorization'){    
            $charge = $viva->setAutorization($client, $transaction);
            //Something went wrong send info to user
            if ($charge['status'] == 0)
                return new JsonResponse([
                    'status' => 0,
                    'message' => $charge['data'],
                    'data' => $charge
                ]);
            
            return new JsonResponse([
                'status' => 1,
                'message' => $charge['data'],
                'data' => $charge
            ]);

        }

        else if($request->request->get('action') == 'charge_capture'){
            $charge = $viva->setCharge($client, $transaction);
            //Something went wrong send info to user
            if ($charge['status'] == 0)
                return new JsonResponse([
                    'status' => 0,
                    'message' => $charge['data'],
                    'data' => $charge
                ]);
            
            $capture = $viva->setCapture($charge['data']->transactionId, $transaction['amount']);
            
            return new JsonResponse([
                'status' => 1,
                'message' => $capture['data'],
                'data' => $capture
            ]);
        }

        else if($request->request->get('action') == 'charge_cancel'){
            $charge = $viva->setCharge($client, $transaction);

            //Something went wrong send info to user
            if ($charge['status'] == 0)
                return new JsonResponse([
                    'status' => 0,
                    'message' => $charge['data'],
                    'data' => $charge
                ]);
            
            //
            $cancel = $viva->setCancel($charge['data']->transactionId, $transaction['amount']);
            
            return new JsonResponse([
                'status' => 1,
                'message' => $cancel['data'],
                'data' => $cancel
            ]);

        }

        //Something went wrong send info to user
            return new JsonResponse([
                'status' => 0,
                'message' => 'Not Processed',
                'data' => null
            ]);
    }

}
