<?php

namespace App\Http\Controllers;

use App\Models\User;

abstract class Controller
{
    public function get_token_user($data){
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
        return $user;
    }
}
