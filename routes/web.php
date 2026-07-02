<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SubjectController;
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

// subjects
Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.menu');
Route::post('/subjects', [SubjectController::class, 'addSubject'])->name('subjects.add');
Route::put('/subjects', [SubjectController::class, 'editSubject'])->name('subjects.update');
// Route::delete('/subjects/{subject}', [SubjectController::class, 'deleteSubject'])->name('subjects.delete');

// Assignments
Route::get('/subjects/{subject}/details', [AssignmentController::class, 'index'])->name('subjects.details');
Route::post('/assignments', [AssignmentController::class, 'addAssignment'])->name('assignments.add');
Route::put('/assignments', [AssignmentController::class, 'editAssignment'])->name('assignments.update');
Route::post('/assignments/mark-completed', [AssignmentController::class, 'markAsCompleted'])->name('assignments.markAsCompleted');
// Route::delete('/assignments/{assignment}', [AssignmentController::class, 'deleteAssignment'])->name('assignments.delete');

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