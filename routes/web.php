<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
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
Route::delete('/subjects/delete', [SubjectController::class, 'deleteSubject'])->name('subjects.delete');

// Assignments
Route::get('/subjects/{subject}/details', [AssignmentController::class, 'index'])->name('subjects.details');
Route::post('/assignments', [AssignmentController::class, 'addAssignment'])->name('assignments.add');
Route::put('/assignments', [AssignmentController::class, 'editAssignment'])->name('assignments.update');
Route::post('/assignments/mark-completed', [AssignmentController::class, 'markAsCompleted'])->name('assignments.markAsCompleted');
Route::delete('/assignments/delete', [AssignmentController::class, 'deleteAssignment'])->name('assignments.delete');

//Schedule
Route::get('/schedule', [AssignmentController::class, 'schedule'])->name('schedule');

// Settings
Route::get('/settings', function () {
    return view('pages.settings.settings');
});

// Settings
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'mount'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/security', function () {
        return view('pages.settings.security');
    })->name('security');

    Route::get('/security/update-password', function () {
        return view('pages.settings.update-password');
    })->name('security.update-password');

    Route::put('/security/update-password', [AuthController::class, 'updatePassword'])->name('security.update-password');

    Route::get('/security/verify-email', function () {
        return view('pages.settings.verify-email');
    })->name('security.verify-email');

    // Route::post('/security/verify-email', [AuthController::class, 'resendVerificationNotification'])->name('security.verification.resend');

    Route::get('/security/enable-2fa', function () {
        return view('pages.settings.enable-2fa');
    })->name('security.enable-2fa');

    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-as-read');

    // Add route for delete account here
    // Route::delete('/others/delete-account', [AuthController::class, 'deleteAccount'])->name('delete-account');
});

require __DIR__.'/settings.php';
