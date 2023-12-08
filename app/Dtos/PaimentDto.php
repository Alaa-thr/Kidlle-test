<?php

namespace App\Dtos;

class PaimentDto 
{
    private $amount;
    private $currency;
    private $cardNumber;

    public function __construct($amount, $currency, $cardNumber)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->cardNumber = $cardNumber;
    }

    public function getAmount()
    {
        return $this->amount;
    }
    public function getCurrency()
    {
        return $this->currency;
    }
    public function getCardNumber()
    {
        return $this->cardNumber;
    }
}