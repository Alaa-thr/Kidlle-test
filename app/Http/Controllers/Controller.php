<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Interfaces\IPaiment;
use App\Dtos\PaimentDto;

class Controller extends BaseController
{
    private $service;
    public function constructer(IPaiment $service){
        $this->service = $service;
    }
    public function store(Request $request){
       
        //get data from the request
        $paimentType = $request->input('paimentType');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $cardNumber = $request->input('cardNumber');
        //create dto with necessary data
        $paimentDto = new PaimentDto($amount,$currency,$cardNumber);
        //call paiment processe
        $result = $this->ProcessPayment($paimentDto);
        return response()->json([
            'succes' => $result,
            'error_message' => ''
        ]);
    }
    public function show($paimentType,$id){
        try{
            //cal paiment details
            $result = $this->getPayment($paimentType, $id);
            return response()->json([
                'succes' => true,
                'error_message' => '',
                'data' => $result
            ]);
        }catch(Exception $exception){
            return response()->json([
                'succes' => false,
                'error_message' => $exception->getMessage(),
                'data' => null
            ]);
        }
    }
}
