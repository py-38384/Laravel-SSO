<?php

namespace App\Http\Controllers;

use App\Facades\SharedEncrypt;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function index(){
        $encrpted_data = SharedEncrypt::encrypt("piyal is a programmer");
        dump($encrpted_data);
        $decrpted_data = SharedEncrypt::decrypt($encrpted_data);
        dd($decrpted_data);
    }
}
