<?php

namespace App\Http\Middleware;

use App\Facades\SharedEncrypt;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class TokenAutologin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $encryptedToken = $request->get("token");
        if($encryptedToken) {
            $token = SharedEncrypt::decrypt($encryptedToken);
            if(Auth::guard("web")->guest() && $token){
                $accessToken = PersonalAccessToken::findToken($token);
                $user = $accessToken?->tokenable;
                if($user){
                    Auth::login($user);
                }
            }
        }
        return $next($request);
    }
}
