<?php

namespace App\Service;

use \VgsPedro\VivaApi\Transaction\Authorization;
use \VgsPedro\VivaApi\Transaction\Url;
use \VgsPedro\VivaApi\Transaction\Customer;
use \VgsPedro\VivaApi\Transaction\Charge;
use \VgsPedro\VivaApi\Transaction\Capture;
use \VgsPedro\VivaApi\Transaction\Cancel;
use \VgsPedro\VivaApi\Transaction\ChargeToken;
use \VgsPedro\VivaApi\Transaction\Installments;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class VivaWallet
{

	private $test_mode; // Boolean 
 	private $client_id; // Client ID, Provided by wallet
 	private $client_secret; // Client Secret, Provided by wallet
    private $url; // Url to make request, sandbox or live (sandbox APP_ENV=dev or test) (live APP_ENV=prod)
    private $merchant_id; //Merchant ID , Provided by wallet
    private $api_key; //Api Key, Provided by wallet
	private $headers; //Set the authorization to curl

    public function __construct(ParameterBagInterface $environment){
		$this->test_mode = true;
 		$this->client_id = 'ajtcj1jbpzujbd66mzouuar2sqyybdvvuc8w4hvk2xh24.apps.vivapayments.com';
		$this->client_secret = 'U3sKcYAY6FO03O5gUAA82b3xN76sqH';
		$this->api_key = 'z6$4s+';
        $this->url = $environment->get("kernel.environment") == 'prod' ? 'https://www.vivapayments.com' : 'https://demo-api.vivapayments.com';
    }

	/**
	* Create an authentication Token to pass to client side js  
	* @return string $accessToken 
	**/
	public function getCardChargeToken(){

		$baseUrl = Url::getUrl($this->test_mode); //Test mode, default is false
		$accessToken = (new Authorization())
		->setClientId($this->client_id) // Client ID, Provided by wallet
		->setClientSecret($this->client_secret) // Client Secret, Provided by wallet
		->setTestMode($this->test_mode) // Test mode, default is false, can be skipped
		->getAccessToken();
		return $accessToken;
	}

	/**
	* Create a charge transaction
	*@param $client // Information of the user 
	*@param $trans // Information of the charge transaction 
	**/	
	public function setCharge(array $client, array $trans){

		$customer = (new Customer())
			->setEmail($client['email'])
			->setPhone($client['phone'])
			->setFullName($client['full_name'])
	      	->setRequestLang($client['request_lang'])
      		->setCountryCode($client['country_code']);

		$transaction = (new Charge())
			->setClientId($this->client_id) // Client ID, Provided by wallet
			->setClientSecret($this->client_secret) // Client Secret, Provided by wallet
			->setTestMode($this->test_mode) // Test mode, default is false, can be skipped
			->setSourceCode('') // Source code, provided by wallet
			->setAmount($trans['amount']) // The amount to charge in currency's smallest denomination (e.g amount in pounds x 100)
			->setInstallments($trans['installments']) // Installments, can be skipped if not used
			->setChargeToken($trans['charge_token']) // Charge token obtained at front end
 			->setMerchantTrns( $trans['merchant_trans'])
 			->setCustomerTrns($trans['customer_trans'])
			->setTipAmount($trans['tip_amount'])
			->setCustomer($customer)
			->setPreAuth($trans['pre_auth']); //If true, a PreAuth transaction will be performed. This will hold the selected amount as unavailable (without the customer being charged) for a period of time.

		$result = $transaction->send();

		if (!empty($transaction->getError()))
			return [
				'status' => 0,
				'data' => $transaction->getError()
			];
			
		return [
			'status' => 1,
			'data' => $result
		];
	}

	/**
	* Create a charge transaction, the amount is captured and charged. 
	*@param $client // Information of the user 
	*@param $trans // Information of the charge transaction 
	**/	
	public function setAutorization(array $client, array $trans){

		$customer = (new Customer())
			->setEmail($client['email'])
			->setPhone($client['phone'])
			->setFullName($client['full_name'])
	      	->setRequestLang($client['request_lang'])
      		->setCountryCode($client['country_code']);

		$transaction = (new Authorization())
			->setClientId($this->client_id) // Client ID, Provided by wallet
			->setClientSecret($this->client_secret) // Client Secret, Provided by wallet
			->setTestMode($this->test_mode) // Test mode, default is false, can be skipped
			->setSourceCode('') // Source code, provided by wallet
			->setAmount($trans['amount']) // The amount to pre-auth in currency's smallest denomination (e.g amount in pounds x 100)
			->setInstallments($trans['installments']) // Installments, can be skipped if not used
			->setChargeToken($trans['charge_token']) // Charge token obtained at front end
			->setCustomer($customer)
			->setPreAuth($trans['pre_auth']);//If true, a PreAuth transaction will be performed. This will hold the selected amount as unavailable (without the customer being charged) for a period of time.

		$result = $transaction->send();

		if (!empty($transaction->getError()))
			return [
				'status' => 0,
				'data' => $transaction->getError()
			];
			
		return [
			'status' => 1,
			'data' => $result
		];
	}


	/**
	* Capture a charge transaction
	*@param $t_i // Transaction id of authorization transaction
	*@param $amount // The amount to capture in currency's smallest denomination (e.g amount in pounds x 100)
	**/
	public function setCapture(string $t_i, int $amount){

		$transaction = (new Capture())
			->setClientId($this->client_id) // Client ID, Provided by wallet
			->setClientSecret($this->client_secret) // Client Secret, Provided by wallet
			->setTestMode($this->test_mode) // Test mode, default is false, can be skipped
			->setTransactionId($t_i) // Transaction id of authorization transaction
			->setAmount($amount); // The amount to capture in currency's smallest denomination (e.g amount in pounds x 100)

		$result = $transaction->send();

		if (!empty($transaction->getError()))
			return [
				'status' => 0,
				'data' => $transaction->getError()
			];
			
		return [
			'status' => 1,
			'data' => $result
		];
	}


	/**
	* Cancel a charge transaction
	*@param  $t_i // Transaction id of authorization transaction
	*@param $amount // The amount to capture in currency's smallest denomination (e.g amount in pounds x 100)
	**/
	public function setCancel(string $t_i, int $amount){

		$transaction = (new Cancel())
			->setClientId($this->client_id) // Client ID, Provided by wallet
			->setClientSecret($this->client_secret) // Client Secret, Provided by wallet
			->setTestMode($this->test_mode) // Test mode, default is false, can be skipped
			->setTransactionId($t_i) // Transaction id of authorization transaction
			->setAmount($amount)// The amount to capture in currency's smallest denomination (e.g amount in pounds x 100)
			->setSourceCode(''); // Source code, provided by wallet

		$result = $transaction->send();

		if (!empty($transaction->getError()))
			return [
				'status' => 0,
				'data' => $transaction->getError()
			];
			
		return [
			'status' => 1,
			'data' => $result
		];
	}



	/**
	* Is possible to get charge token at backend.
	* It may be required in custom integration, more details can be found here: https://developer.vivawallet.com/online-checkouts/native-checkout-v2/
	* @param $card // All the info of the card to make the charge
	* @param $url_redirect // Url to redirect when authentication session finished
	**/
	public function getChargeTokenAtBackend(array $card, string $url_redirect){

		$transaction = (new ChargeToken())
			->setClientId($this->client_id) // Client ID, Provided by wallet
			->setClientSecret($this->client_secret) // Client Secret, Provided by wallet
			->setTestMode($this->test_mode) // Test mode, default is false, can be skipped
			->setAmount($card['amount']) // The amount in currency's smallest denomination (e.g amount in pounds x 100)
			->setCvc($card['cvc']) // Card cvc code
			->setNumber($card['card_number']) // Card number
			->setHolderName($card['holder_name']) // Card holder name
			->setExpirationYear($card['expiration_year']) // Card expiration year
			->setExpirationMonth($card['expiration_month']) // Card expiration month
			->setSessionRedirectUrl($url_redirect); // Url to redirect when authentication session finished
		$result = $transaction->send();

		if (!empty($transaction->getError()))
			return [
				'status' => 0,
				'data' => $transaction->getError()
			];
			
		// Get charge token
		// $chargeToken = $result->chargeToken;
		// $redirectToACSForm = $result->redirectToACSForm;	
		return [
			'status' => 1,
			'data' => $result
		];

	}

	/**
	* Check for installments
	* Retrieve the maximum number of installments allowed on a card.
	*@param $card_number // Number of the credit card
	**/
	public function getInstalments(string $card_number){

		$transaction = (new Installments())
			->setClientId($this->client_id) // Client ID, Provided by wallet
			->setClientSecret($this->client_secret) // Client Secret, Provided by wallet
			->setTestMode($this->test_mode) // Test mode, default is false, can be skipped
			->setNumber($card_number); // Card number

		$result = $transaction->send();

		if (!empty($transaction->getError()))
			return [
				'status' => 0,
				'data' => $transaction->getError()
			];
			
		// Get number of installments
		// $installments = $result->maxInstallments;
		return [
			'status' => 1,
			'data' => $result
		];
	}
}