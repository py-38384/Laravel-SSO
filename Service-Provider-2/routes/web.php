<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrimaryController;

Route::get('/', [PrimaryController::class,'index'])->name('home');
Route::get('/identity', [PrimaryController::class,'identify'])->name('identify');