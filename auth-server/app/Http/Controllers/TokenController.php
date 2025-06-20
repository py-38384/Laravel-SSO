<?php

namespace App\Http\Controllers;

use App\Models\SanctumKey;
use Illuminate\Http\Request;
use App\Facades\SharedEncrypt;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
    public function get_user_data(){
        $user = auth()->user();
        return $user->toArray();
    }
    public function token_logout(Request $request) {
        $encryptedToken = $request->get('token');
        $next = $request->get('next');
        if(!$encryptedToken){
            abort(404);
        }
        $token = SharedEncrypt::decrypt($encryptedToken);
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
    public function createTokenAndRedirect(Request $request){
        if($request->next){
            $next = $request->next;
            $user = auth()->user();
            if($user->token){
                $plain_text_token = decrypt($user->token->token);
                $shared_encripted_token = SharedEncrypt::encrypt($plain_text_token);
                return redirect("$next?token=$shared_encripted_token");
            }
            $token = auth()->user()->createToken("token");
            $plain_text_token = $token->plainTextToken;
            $token_id = $token->accessToken->id;

            $newSanctumKey = new SanctumKey();
            $newSanctumKey->user_id = $user->id;
            $newSanctumKey->token = encrypt($plain_text_token);
            $newSanctumKey->token_id = $token_id;
            $newSanctumKey->save();

            $shared_encripted_token = SharedEncrypt::encrypt($plain_text_token);
            return redirect("$next?token=$shared_encripted_token");
        }
        abort(404);
    }
}
