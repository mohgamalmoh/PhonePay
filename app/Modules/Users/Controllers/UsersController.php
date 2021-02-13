<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\UsersService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    private $usersService;

    function __construct(UsersService $userService) {
        $this->usersService = $userService;
      }
      
    public function register(RegisterRequest $request)
    {
        try{
            $this->usersService->register($request->validated());
            return response()->json(['message'=>'success'],200);
            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()],400);
        }
        
    }

    public function login(LoginRequest $request)
    {
        try{
            $token = $this->usersService->login($request->validated());
            return response()->json(['message'=>'success' , 'token'=>$token],200);
            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()],400);
        }
    }

    public function walletBalance(){
        try{
            $balance = $this->usersService->walletBalance();
            return response()->json(['message'=>'success' , 'data'=>$balance],200);
            
        }catch (\Exception $e) {
            return response()->json(['message'=>$e->getMessage()],400);
        }
    }
}