<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => ["required", "min:4", "max:100",],
            "email" => ["required", "email","unique:users,email"],
            "password" => ["required", "min:6"],
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'error' => $validate->errors(),
            ],401);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'success'=> true,
            'message'=> 'Registration Successful',
            'token' => $user->createToken('token')->plainTextToken,
        ]);
    }
    public function logout(){
        $user = auth()->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            "success"=> true,
            "message"=> "Log Out Successful",
        ]);
    }
    public function login(Request $request){
        $validate = Validator::make($request->all(), [
            "email" => ["required", "email"],
            "password" => ["required", "min:6"],
        ]);
        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Failed',
                'error' => $validate->errors(),
            ], 401);
        }
        if(Auth::attempt(['email' => $request['email'], 'password' => $request['password']])){
            return response()->json([
                'success' => true,
                'email' => auth()->user()->email,
                'token' => auth()->user()->createToken('token')->plainTextToken,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed',
                'error' => 'Invaild Credentials',
            ], 401);
        }
    }
}
