<?php

namespace App\Services;

use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use App\Services\UsersService;

class TransactionsVerificationService
{
    
    
    private $transactionRepository;
    private $usersService;

    function __construct(TransactionRepository $transactionRepository, UsersService $userService) {
        $this->transactionRepository = $transactionRepository;
        $this->usersService = $userService;
    }

    public function verifyTransactionById($transaction_id)
    {
    
        if($this->isTransactionValid($transaction_id)){
            $transaction = $this->transactionRepository->getTransactionById($transaction_id);
            $this->transactionRepository->fillTransactionVerificationFieldByCrrentTimeStamp($transaction_id);
            $this->usersService->addAmountToUserWallet($transaction->from, -$transaction->amount);
            $this->usersService->addAmountToUserWallet($transaction->to, $transaction->amount);
            return true;
        }
        return false;
        
    }

    public function isTransactionValid($transaction_id)
    {
        $transaction = $this->transactionRepository->getTransactionById($transaction_id);
        return Carbon::parse($transaction->created_at)->addMinutes(5)->gte(Carbon::now());
    
        
    }

}