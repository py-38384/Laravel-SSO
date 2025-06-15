<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Facades\SharedEncrypt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PrimaryController extends Controller
{
    function index() {
        return view('welcome');
    }
    public function identify(Request $request)
    {
        $token = SharedEncrypt::decrypt($request->get("token"));
        $response = Http::withToken($token)
            ->accept('application/json')
            ->get(config('app.auth_server_get_user_data_url'));
        if ($response->successful()) {
            $data = $response->json();
            $user = null;
            if (User::where('user_id', $data['id'])->exists()) {
                $user = User::where('user_id', $data['id'])->first();
            } else {
                $user = User::create([
                    'user_id' => $data['id'],
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt('password'),
                ]);
            }
            Cache::forever('authenticated', true);
            Cache::forever('token', $token);
            Cache::forever('user_local_id', $user->id);
            Cache::forever('user_remote_id', $user->user_id);
            return redirect(route('home'));
        } else {
            throw new Exception('Token Validation Faild');
        }
    }
}
