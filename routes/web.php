<?php

app()->setLocale('pl');

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


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return view('dashboard', compact('user'));
    })->name('dashboard');
});


use App\Http\Controllers\SurveyController;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');
    Route::get('/dashboard', [SurveyController::class, 'dashboard'])->name('dashboard');
});

Route::get('/surveys/{survey:uuid}/link', [SurveyController::class, 'link'])->middleware('auth')->name('surveys.link');

Route::get('/survey/{survey:uuid}', [SurveyController::class, 'show'])->name('surveys.show');
Route::post('/survey/{survey:uuid}', [SurveyController::class, 'answer'])->name('surveys.answer');


Route::get('/surveys/{survey:uuid}/statistics', [SurveyController::class, 'statistics'])->name('surveys.statistics');


Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');

Route::get('/surveys/{survey:uuid}/votes', [App\Http\Controllers\SurveyController::class, 'votes'])
    ->middleware(['auth'])
    ->name('surveys.votes');

Route::delete('/surveys/{survey}', [App\Http\Controllers\SurveyController::class, 'destroy'])
    ->middleware('auth')
    ->name('surveys.destroy');


use App\Http\Middleware\IsAdmin;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminSurveyController;
use App\Http\Controllers\Admin\AdminQuestionController;

Route::middleware(['auth', IsAdmin::class])->prefix('admin')->group(function () {
    // Zarządzanie użytkownikami
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    // Zarządzanie ankietami
    Route::get('/surveys', [AdminSurveyController::class, 'index'])->name('admin.surveys');
    Route::delete('/surveys/{survey}', [AdminSurveyController::class, 'destroy'])->name('admin.surveys.destroy');
});




Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    // Użytkownicy
    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');

    // Ankiety
    Route::get('/surveys', [AdminSurveyController::class, 'index'])->name('surveys');
    Route::get('/surveys/{survey}/edit', [AdminSurveyController::class, 'edit'])->name('surveys.edit');
    Route::put('/surveys/{survey}', [AdminSurveyController::class, 'update'])->name('surveys.update');

    // Pytania do ankiet (questions)
    Route::get('/questions/create', [AdminQuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [AdminQuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('questions.destroy');
});
