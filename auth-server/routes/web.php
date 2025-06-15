<?php

use App\Http\Controllers\PrimaryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RedirectTokenController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [PrimaryController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/generate/base64/code', [TestController::class, 'generate_base64_encode'])->name('generate.base64.encode');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('redirect/token',[RedirectTokenController::class,'index'])->name('redirect.token');
});

require __DIR__.'/auth.php';
