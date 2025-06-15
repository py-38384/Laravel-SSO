<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;


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
}
