<?php

namespace App\Services;
use App\PaimentsModule\Traits\StripeTrait;


class StripePaimentService implements IPaiment
{
    use StripeTrait;

    public function getPayment($id){
        return $this->stripeGetPayment($id);
    }
    public function ProcessPayment($amount, $currency, $cardNumber){
        return $this->stripePaymentProcess($amount, $currency, $cardNumber);
    }

}