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
    public function dashboard(Request $request) {
        return view('dashboard');
    }
    public function generate_base64_encode(){
        dd(base64_encode(random_bytes(32)));
    }
}
