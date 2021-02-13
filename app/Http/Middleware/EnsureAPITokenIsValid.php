<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class EnsureAPITokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $authHeader = $request->header('Authorization');
        if(!$authHeader){
            return response()->json(['message'=>'Unauthenticated'],401);
        }

        $user = User::where('api_token',$authHeader)->first();
        if(!$user){
            return response()->json(['message'=>'Unauthenticated'],401);
        }

        Auth::login($user);
        return $next($request);
        
    }
}
