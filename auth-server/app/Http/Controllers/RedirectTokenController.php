<?php

namespace App\Http\Controllers;

use App\Facades\SharedEncrypt;
use App\Models\SanctumKey;
use Illuminate\Http\Request;

class RedirectTokenController extends Controller
{
    public function index(Request $request){
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
            $token_id = $token->accessToken->id;;

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
