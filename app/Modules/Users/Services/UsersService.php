<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Repositories\UserRepository;

class UsersService
{

    private $userRepository;

    function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
      }

    public function register($data)
    {
        
        try{
            $data['wallet_balance'] =  1000;
            $data['password'] =  Hash::make($data['password']);
            $this->userRepository->createUser($data);
            
        }catch (\Exception $e) {
            //log the error
            throw new \Exception("User Creation Failed");
        }

    }


    public function login($data)
    {
        
        $user = $this->userRepository->getUserByMobile($data['mobile']);
        
        if($user){
            if(!Hash::check($data['password'], $user->password)){
                throw new \Exception("Invalid Credentials");
            }
        }else{
            throw new \Exception("Invalid Credentials");
        }

        $user->api_token = (string) Str::uuid();
        $user->save();
        return $user->api_token;
    }


    public function walletBalance()
    {
        $user = Auth::user();
        return $user->wallet_balance;
        
    }

    public function addAmountToUserWallet($user_id,$amount)
    {
        $this->userRepository->addAmountToUserWalletBalanceFeild($user_id,$amount);
        
    }

}