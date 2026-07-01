<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Auth
Route::get('/login', function () {
    return view('pages.auth.login');
});
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

Route::get('/register', function () {
    return view('pages.auth.register');
});
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// Assignments
Route::get('/assignments', function () {
    return view('pages.assignments.menu');
});

Route::get('/assignments/details', function () {
    return view('pages.assignments.details');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
