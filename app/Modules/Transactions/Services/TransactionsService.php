<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TwilioService;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;

class TransactionsService
{
    
    private $twilioService;
    private $transactionRepository;
    private $userRepository;

    function __construct(TwilioService $twilioService, TransactionRepository $transactionRepository, UserRepository $userRepository) {
        $this->twilioService = $twilioService;
        $this->transactionRepository = $transactionRepository;
        $this->userRepository = $userRepository;
    }


    public function makeTransaction($data)
    {

        $authUser = Auth::user();
        if($authUser->wallet_balance < $data['amount']){
            throw new \Exception("Insufficient Balance");
        }

        try{
            $data['from'] = $authUser->id;
            $toUser = $this->userRepository->getUserByMobile($data['to']);
            $data['to'] = $toUser->id;
            $transaction = $this->transactionRepository->createTransaction($data);
            $this->twilioService->callUserToVerifyTransaction($authUser,$transaction);
            
        }catch (\Exception $e) {
            throw new \Exception("Transaction Failed");
        }

    
        return $transaction;
    }

    public function getTransactions()
    {

            $authUser = Auth::user();
            $transactions = $this->transactionRepository->getTransactionsByUserId($authUser->id);
            return $transactions;
        

    
        return $transaction;
    }


}