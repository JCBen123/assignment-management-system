<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

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
