<?php

namespace App\Repositories;

use App\Models\Transaction;
use Carbon\Carbon;

class TransactionRepository
{
    
    public function createTransaction($data)
    {
    
        try{
            $transaction = Transaction::create($data);
            return $transaction;
            
        }catch (\Exception $e) {
            //log the error
            throw new \Exception("Transaction Saving Failed");
        }
        
    }

    public function getTransactionsByUserId($user_id)
    {
    
        try{
            $transactions = Transaction::where('from',$user_id)->get();
            return $transactions;
            
        }catch (\Exception $e) {
            //log the error
            throw new \Exception("Transactions retreival Failed");
        }
        
    }

    public function fillTransactionVerificationFieldByCrrentTimeStamp($transaction_id)
    {
    
        try{
            $transaction = Transaction::find($transaction_id);
            $transaction->mobile_verified_at = Carbon::now()->toDateTimeString();
            $transaction->save();
            
        }catch (\Exception $e) {
            //log the error
            throw new \Exception("Transaction verification Saving Failed");
        }
        
    }

    public function getTransactionById($transaction_id)
    {
    
        try{
            return Transaction::find($transaction_id);
            
        }catch (\Exception $e) {
            throw new \Exception("Transaction doestn't exist");
        }
        
    }


   

}