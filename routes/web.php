<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {

    Route::redirect('/', '/ideas');
    Route::get('/ideas', [IdeaController::class, 'index'])->name('home');
    Route::get('/ideas/{idea}', [IdeaController::class, 'show'])->name('idea.show');
    Route::post('/ideas', [IdeaController::class, 'store'])->name('idea.store');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('idea.destroy');
    Route::post('/logout', [SessionsController::class, 'destroy'])->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
    Route::get('/login', [SessionsController::class, 'create'])->name('login');
    Route::post('/login', [SessionsController::class, 'store'])->name('login.store');
});
