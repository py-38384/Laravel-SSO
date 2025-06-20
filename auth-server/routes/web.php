<?php

use App\Http\Controllers\PrimaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectTokenController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TokenController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Laravel SSO route
Route::get('dashboard', [PrimaryController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('token-logout', [TokenController::class, 'token_logout'])->name('token.logout');
Route::get('redirect/token',[TokenController::class,'createTokenAndRedirect'])->name('redirect.token');

Route::get('/generate/base64/code', [TestController::class, 'generate_base64_encode'])->name('generate.base64.encode');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
