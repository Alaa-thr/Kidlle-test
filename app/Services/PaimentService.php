<?php

namespace App\Services;
use App\PaimentsModule\Traits\PaypalTrait;
use App\PaimentsModule\Traits\StripeTrait;
use App\Dtos\PaimentDto;
use App\Interfaces\IPaiment;

class PaimentService implements IPaiment
{
    use PaypalTrait;
    use StripeTrait;

    public function getPayment($paimentType,$id){
        try{
            $result = null;
            switch ($paimentType) {
                case "paypal":
                    $result = $this->paypalGetPayment($id);
                    break;
                case "stripe":
                    $result = $this->stripeGetPayment($id);
                    break;
            }
            return $result;
        }catch(Exception $exception){
            throw new Exception($exception->getMessage());
        }
        
            
    }
    public function ProcessPayment($paimentType,PaimentDto $paimentDto){
        switch ($paimentType) {
            case "paypal":
                return $this->paypalPaymentProcess($paimentDto);
                break;
            case "stripe":
                return $this->stripePaymentProcess($paimentDto);
                break;
        }
    }

}