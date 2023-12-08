<?php

namespace App\Interfaces;

use App\Dtos\PaimentDto;

interface IPaiment
{

    public function getPayment($paimentType,$id);
    public function ProcessPayment($paimentType,PaimentDto $paimentDto);


}