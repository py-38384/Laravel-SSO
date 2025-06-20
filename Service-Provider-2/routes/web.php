<?php

use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/identity', [TokenController::class,'identify'])->name('identify');