<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\PrimaryController;
use App\Http\Controllers\TokenController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register',[AuthController::class, 'register']);
Route::delete('/logout',[AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/login',[AuthController::class, 'login']);
Route::post('/update/user',[AuthController::class, 'update']);
Route::get('/get/user/data',[TokenController::class, 'get_user_data'])->middleware('auth:sanctum');
