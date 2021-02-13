<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TransactionsService;
use App\Http\Requests\TransactionRequest;
use App\Services\TwilioService;

class TransactionsController extends Controller
{
    private $transactionsService;
    private $twilioService;

    function __construct(TransactionsService $transactionsService,TwilioService $twilioService) {
        $this->transactionsService = $transactionsService;
        $this->twilioService = $twilioService;
      }
      
    public function makeTransaction(TransactionRequest $request)
    {
        try{

            $this->transactionsService->makeTransaction($request->validated());
            return response()->json(['message'=>'success' , 'data'=>''],200);
            
        }catch (\Exception $e) {

            return response()->json(['message'=>$e->getMessage()],400);

        }
    }

    public function getTransactions()
    {
        try{

            $transactions = $this->transactionsService->getTransactions();
            return response()->json(['message'=>'success' , 'data'=>$transactions],200);
            
        }catch (\Exception $e) {

            return response()->json(['message'=>$e->getMessage()],400);

        }
    }

    public function twilioWebhook($id)
    {
        try{

            echo $this->twilioService->webhook($id);
            
        }catch (\Exception $e) {

            return response()->json(['message'=>$e->getMessage()],400);

        }
    }

    public function verifyTransaction($id)
    {
        try{

            echo $this->twilioService->verification($id);
            
        }catch (\Exception $e) {

            return response()->json(['message'=>$e->getMessage()],400);

        }
    }

    


}