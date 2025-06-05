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



Route::post('/login', [LoginController::class, 'login']);


Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

use Illuminate\Support\Facades\Auth;


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();

        return view('dashboard', compact('user'));
    })->name('dashboard');
});


use App\Http\Controllers\SurveyController;


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
use App\Http\Controllers\Admin\AdminAnswerController;
use App\Http\Controllers\Admin\AdminOptionController;




Route::middleware(['auth', IsAdmin::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {


    Route::get('/users', [AdminUserController::class, 'index'])->name('users');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

 
    Route::get('/surveys', [AdminSurveyController::class, 'index'])->name('surveys');
    Route::get('/surveys/{survey}/edit', [AdminSurveyController::class, 'edit'])->name('surveys.edit');
    Route::put('/surveys/{survey}', [AdminSurveyController::class, 'update'])->name('surveys.update');
    Route::delete('/surveys/{survey}', [AdminSurveyController::class, 'destroy'])->name('surveys.destroy');



 
    Route::get('/questions/create', [AdminQuestionController::class, 'create'])->name('questions.create');
    Route::post('/questions', [AdminQuestionController::class, 'store'])->name('questions.store');
    Route::get('/questions/{question}/edit', [AdminQuestionController::class, 'edit'])->name('questions.edit');
    Route::put('/questions/{question}', [AdminQuestionController::class, 'update'])->name('questions.update');
    Route::delete('/questions/{question}', [AdminQuestionController::class, 'destroy'])->name('questions.destroy');
    Route::post('/answers', [AdminAnswerController::class, 'store'])->name('answers.store');
    Route::put('/answers/{answer}', [AdminAnswerController::class, 'update'])->name('answers.update');
    Route::delete('/answers/{answer}', [AdminAnswerController::class, 'destroy'])->name('answers.destroy');
    

    Route::post('options', [AdminOptionController::class, 'store'])->name('options.store');
    Route::put('options/{option}', [AdminOptionController::class, 'update'])->name('options.update');
    Route::delete('options/{option}', [AdminOptionController::class, 'destroy'])->name('options.destroy');

    Route::post('/options/reorder/{question}', [AdminOptionController::class, 'reorder'])
     ->name('options.reorder');
});