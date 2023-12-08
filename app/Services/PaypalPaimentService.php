<?php

namespace App\Services;
use App\PaimentsModule\Traits\PaypalTrait;

class PaypalPaimentService implements IPaiment
{
    use PaypalTrait;

    public function getPayment($id){
        return $this->paypalGetPayment($id);
    }
    public function ProcessPayment($amount, $currency){
        return $this->paypalPaymentProcess($amount, $currency);
    }

}