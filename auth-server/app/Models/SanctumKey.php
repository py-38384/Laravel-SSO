<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class SanctumKey extends Model
{
    public function user(){
        $this->belongsTo(User::class);
    }
}
