<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facades\SharedEncrypt;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\PersonalAccessToken;


class PrimaryController extends Controller
{
    public function index(){
        return ["greeting" => "hallo world"];
    }
    public function get_user_data(){
        $user = auth()->user();
        return $user->toArray();
    }
    public function dashboard(Request $request) {
        return view('dashboard');
    }
    public function generate_base64_encode(){
        dd(base64_encode(random_bytes(32)));
    }
    public function token_logout(Request $request) {
        $rawToken = $request->get('token');
        $next = $request->get('next');
        if(!$rawToken){
            abort(404);
        }
        $token = SharedEncrypt::decrypt($rawToken);
        $accessToken = PersonalAccessToken::findToken($token);
        $user = $accessToken?->tokenable;
        if(!$user){
            abort(404);
        }
        $token_id = $user->token->token_id;
        $user->tokens()->where('id', $token_id)->delete();
        $user->token->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect($next);
    }
}
