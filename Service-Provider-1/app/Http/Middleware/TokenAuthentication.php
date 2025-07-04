<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class TokenAuthentication
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authenticated = cache("authenticated");
        // dd($authenticated);
        if ($authenticated) {
            $token = cache("token");
            $response = Http::withToken($token)
            ->accept('application/json')
            ->get('http://authserver.local:8000/api/get/user/data');
            if ($response->successful()) {
                $data = $response->json();
                
                $user = null;
                if(User::where('user_id',$data['id'])->exists()){
                    $user = User::where('user_id',$data['id'])->first();
                } else {
                    $user = User::create([
                        'user_id'=> $data['id'],
                        'name'=> $data['name'],
                        'email'=> $data['email'],
                        'password'=> bcrypt('password'),
                    ]);
                }
                
                auth()->setUser($user);
                Cache::forever('authenticated', true);
                Cache::forever('token', $token);
                Cache::forever('user_local_id', $user->id);
                Cache::forever('user_remote_id', $user->user_id);
                return $next($request);
            } else {
                Cache::forget('authenticated');
                Cache::forget('token');
                Cache::forget('user_local_id');
                Cache::forget('user_remote_id');
            }
        }
        return $next($request);
    }
}
