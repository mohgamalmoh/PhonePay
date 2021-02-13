<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserRepository
{
    
    public function createUser($data)
    {
    
        try{
            User::create($data);
            //$user->save();
            
        }catch (\Exception $e) {
            //log the error
            throw new \Exception("User Saving Failed");
        }
        
    }


    public function getUserByMobile($mobile)
    {
    
        try{
            $user = User::where('mobile',$mobile)->first();
            return $user;
            
        }catch (\Exception $e) {
            //log the error
            throw new \Exception("User Retreival Failed");
        }
        
    }

    public function addAmountToUserWalletBalanceFeild($user_id,$amount)
    {
    
        try{
            $user = User::find($user_id);
            $user->wallet_balance = $user->wallet_balance + $amount;
            $user->save();
            
        }catch (\Exception $e) {
            //log the error
            throw new \Exception("User Wallet Balance Change Failed");
        }
        
    }



   

}