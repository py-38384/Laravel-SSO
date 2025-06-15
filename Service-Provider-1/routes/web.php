<?php

use App\Http\Controllers\PrimaryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/identity', [PrimaryController::class,'identify'])->name('identify');