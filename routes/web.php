<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Contact Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Login Routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    // TODO: Implement authentication logic
    return "Login Logic Not Implemented Yet";
});

Route::post('/logout', function () {
    // TODO: Implement logout logic
    // Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Patient Routes (Protected - will add middleware later)
Route::prefix('patient')->name('patient.')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [PatientController::class, 'updateProfile'])->name('profile.update');
    Route::get('/schedule', [PatientController::class, 'schedule'])->name('schedule');
    Route::get('/manage', [PatientController::class, 'manage'])->name('manage');
    Route::post('/request-deletion', [PatientController::class, 'requestDeletion'])->name('request-deletion');
});

// Doctor Routes (Protected - will add middleware later)
Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('dashboard');
    Route::get('/patients', [DoctorController::class, 'patients'])->name('patients');
    Route::get('/patient/{id}', [DoctorController::class, 'viewPatient'])->name('patient.view');
    Route::get('/patient/{id}/update-status', [DoctorController::class, 'updateStatusForm'])->name('patient.update-status');
    Route::post('/patient/{id}/update-status', [DoctorController::class, 'updateStatus'])->name('patient.update-status.submit');
    Route::get('/patient/{id}/add-record', [DoctorController::class, 'createMedicalRecord'])->name('patient.add-record');
    Route::post('/patient/{id}/add-record', [DoctorController::class, 'storeMedicalRecord'])->name('patient.store-record');
    Route::get('/schedule', [DoctorController::class, 'schedule'])->name('schedule');
    Route::get('/profile', [DoctorController::class, 'profile'])->name('profile');
});

// Legacy dashboard redirect (for backward compatibility)
Route::get('/dashboard', function () {
    // TODO: Redirect based on user role after authentication
    return redirect()->route('patient.dashboard');
})->name('dashboard');
