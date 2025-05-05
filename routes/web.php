<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});


use App\Http\Controllers\RegisterController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});


use App\Http\Controllers\LoginController;


Route::get('/login', function () {
    return view('auth.login');
})->name('login');


// Obsługa wysłania loginu
Route::post('/login', [LoginController::class, 'login']);

// Wylogowanie (POST dla bezpieczeństwa)
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use Illuminate\Support\Facades\Auth;


Route::middleware(['auth'])->group(function() {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        // (opcjonalnie załaduj relacje, jeśli trzeba)
        // $user->load('surveys');
        return view('dashboard', compact('user'));
    })->name('dashboard');
});

