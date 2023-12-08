<?php

namespace App\PaimentsModule\Traits;
use PayPal\Api\Payment;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Payer;
use App\Dtos\PaimentDto;

trait PaypalTrait
{

    private $apiContext;
    private function setPaypalApi(){
        $paypalConfig = \Config::get('paypal');

        $this->apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret'],
            )
        );

        $this->apiContext->setConfig($paypalConfig['settings']);
    }
    public function paypalPaymentProcess(PaimentDto $paimentDto){
        $this->setPaypalApi();
        //user approvement
        $returnValue = $this->createPayment($paimentDto);
        if($returnValue){
            //proced the payment
            return $this->executePayment($amount, $payerId);
        }
        return $returnValue;
    }
    public function paypalGetPayment($id){
        $this->setPaypalApi();
        $this->initializePayPalApiContext();

        try {
            // get payment details
            $payment = Payment::get($id, $this->apiContext);
            return $payment;
        } catch (Exception $e) {
            return null;
        }
    }
    private function createPayment(PaimentDto $paimentDto)
    {
        $this->initializePayPalApiContext();


        // Create a payer object
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Create an amount object
        $transactionAmount = new Amount();
        $transactionAmount->setTotal($paimentDto->getAmount());
        $transactionAmount->setCurrency($paimentDto->getCurrency());

        // Create a transaction object
        $transaction = new Transaction();
        $transaction->setAmount($transactionAmount);

        // Create a redirect URLs object
        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl(url('/paypal/execute-payment'));
        $redirectUrls->setCancelUrl(url('/'));

        // Create a payment object
        $payment = new Payment();
        $payment->setIntent('sale');
        $payment->setPayer($payer);
        $payment->setTransactions([$transaction]);
        $payment->setRedirectUrls($redirectUrls);

        // Create the payment and get the approval URL
        try {
            $payment->create($this->apiContext);

            // Get the approval URL
            $approvalUrl = $payment->getApprovalLink();

            // Redirect the user to PayPal for approval
            return redirect($approvalUrl);
        } catch (\Exception $e) {
            Log::error(get_class($this).'-- createPayment :: This is an error with message'. $exception->getMessage());
            return false;
        }
    }

    private function executePayment($id, $payerId)
    {
        $this->initializePayPalApiContext();

        // Create a payment execution object
        $execution = new PaymentExecution();
        $execution->setPayerId($payerId);

        // Execute the payment
        try {
            $payment = Payment::get($id, $this->apiContext);
            $payment->execute($execution, $this->apiContext);
            return true;
        } catch (\Exception $e) {
            //log error wih format: ClassName -- FunctionName :: Error Message 
            Log::error(get_class($this).'-- executePayment :: This is an error with message'. $exception->getMessage());      
            return false;
        }
    }
}