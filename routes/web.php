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

// Settings
Route::get('/settings', function () {
    return view('pages.settings.settings');
});

Route::middleware('auth')->get('/profile', function() {
    return view('pages.settings.profile');
})->name('profile');

Route::middleware('auth')->get('/security', function() {
    return view('pages.settings.security');
})->name('security');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';