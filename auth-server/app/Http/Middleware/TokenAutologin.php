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
        $rawToken = $request->get("token");
        if($rawToken) {
            $token = SharedEncrypt::decrypt($rawToken);
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
