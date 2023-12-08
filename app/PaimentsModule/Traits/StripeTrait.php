<?php

namespace App\PaimentsModule\Traits;

use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Dtos\PaimentDto;
use Illuminate\Support\Facades\Log;

trait StripeTrait
{
    private function setStripeApiKey() {
        Stripe::setApiKey(config('app.strip_secret'));
    }
    public function stripePaymentProcess(PaimentDto $paimentDto){
       
        $this->setStripeApiKey();

        try {
             // Create a payment
            $intent = \Stripe\PaymentIntent::create([
                 'amount' => $paimentDto->getAmount(),
                 'currency' => $paimentDto->getCurrency(),
                 'payment_method' => $paimentDto->getCardNumber(),  
            ]);
            return true;
            
        }catch (Exception $exception) {
            //log error wih format: ClassName -- FunctionName :: Error Message 
            Log::error(get_class($this).'-- stripePaymentProcess :: This is an error with message'. $exception->getMessage());
            return false;
        }
    }
    public function stripeGetPayment($id){
        $this->setStripeApiKey();

        try {
            // get Payment details by ID
            $paymentIntent = PaymentIntent::retrieve($id);
            return $paymentIntent;

        } catch (Exception $e) {
            //log error wih format: ClassName -- FunctionName :: Error Message 
            Log::error(get_class($this).'-- stripeGetPayment :: This is an error with message'. $exception->getMessage());
            throw new Exception();
        }
    }
}