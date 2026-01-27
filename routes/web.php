<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes - MediPlus Hospital Management System
|--------------------------------------------------------------------------
*/

// ============================================
// Public Routes
// ============================================

Route::get('/', function () {
    return view('home_v2');
})->name('home');

Route::get('/contact', function () {
    return view('contact_v2');
})->name('contact');

Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// ============================================
// Authentication Routes
// ============================================

// Patient/General Login
Route::get('/login', function () {
    return view('login_v2');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->intended('/admin/dashboard');
        } elseif ($user->role === 'doctor') {
            return redirect()->intended('/doctor/dashboard');
        } else {
            return redirect()->intended('/patient/dashboard');
        }
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ])->onlyInput('email');
})->name('login.submit');

// Doctor Login Portal
Route::get('/doctor/login', function () {
    return view('doctor.login_v2');
})->name('doctor.login');

Route::post('/doctor/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        if ($user->role !== 'doctor') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'This portal is for medical staff only. Please use the appropriate login portal.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();
        return redirect()->intended('/doctor/dashboard');
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ])->onlyInput('email');
})->name('doctor.login.submit');

// Logout
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// ============================================
// Patient Routes (Protected)
// ============================================
Route::prefix('patient')->name('patient.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboardV2'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profileV2'])->name('profile');
    Route::post('/profile', [PatientController::class, 'updateProfileV2'])->name('profile.update');
    Route::get('/schedule', [PatientController::class, 'scheduleV2'])->name('schedule');
    Route::get('/manage', [PatientController::class, 'manageV2'])->name('manage');
    Route::post('/request-deletion', [PatientController::class, 'requestDeletionV2'])->name('request-deletion');
});

// ============================================
// Doctor Routes (Protected)
// ============================================
Route::prefix('doctor')->name('doctor.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [DoctorController::class, 'dashboardV2'])->name('dashboard');
    Route::get('/patients', [DoctorController::class, 'patientsV2'])->name('patients');
    Route::get('/patient/{id}', [DoctorController::class, 'viewPatientV2'])->name('patient.view');
    Route::get('/patient/{id}/update-status', [DoctorController::class, 'updateStatusFormV2'])->name('patient.update-status');
    Route::post('/patient/{id}/update-status', [DoctorController::class, 'updateStatusV2'])->name('patient.update-status.post');
    Route::get('/patient/{id}/add-record', [DoctorController::class, 'createMedicalRecordV2'])->name('patient.create-record');
    Route::post('/patient/{id}/add-record', [DoctorController::class, 'storeMedicalRecordV2'])->name('patient.create-record.post');
    Route::get('/schedule', [DoctorController::class, 'scheduleV2'])->name('schedule');
    Route::get('/profile', [DoctorController::class, 'profileV2'])->name('profile');
});

// ============================================
// Admin Routes
// ============================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboardV2'])->name('dashboard');
    Route::post('/approve/{id}', [AdminController::class, 'approveRequest'])->name('approve');
    Route::post('/reject/{id}', [AdminController::class, 'rejectRequest'])->name('reject');

    // Doctor Management
    Route::get('/doctors', [AdminController::class, 'doctorsV2'])->name('doctors');
    Route::get('/doctor/create', [AdminController::class, 'createDoctorV2'])->name('doctor.create');
    Route::post('/doctor', [AdminController::class, 'storeDoctor'])->name('doctor.store');
    Route::get('/doctor/{id}', [AdminController::class, 'viewDoctorV2'])->name('doctor.view');
    Route::get('/doctor/{id}/edit', [AdminController::class, 'editDoctorV2'])->name('doctor.edit');
    Route::put('/doctor/{id}', [AdminController::class, 'updateDoctor'])->name('doctor.update');
    Route::delete('/doctor/{id}', [AdminController::class, 'deleteDoctor'])->name('doctor.delete');

    // Patient Management
    Route::get('/patients', [AdminController::class, 'patientsV2'])->name('patients');
    Route::get('/patient/{id}', [AdminController::class, 'viewPatientV2'])->name('patient.view');
    Route::get('/patient/{id}/assign', [AdminController::class, 'assignPatientV2'])->name('patient.assign');
    Route::post('/patient/{id}/assign', [AdminController::class, 'assignPatientPost'])->name('patient.assign.post');

    // Assignments
    Route::get('/assignments', [AdminController::class, 'assignmentsV2'])->name('assignments');
    Route::post('/assignment', [AdminController::class, 'storeAssignment'])->name('assignment.store');
    Route::delete('/assignment/{id}', [AdminController::class, 'deleteAssignment'])->name('assignment.delete');

    // Deletion Requests
    Route::post('/approve-deletion/{id}', [AdminController::class, 'approveDeletion'])->name('approve-deletion');
    Route::post('/reject-deletion/{id}', [AdminController::class, 'rejectDeletion'])->name('reject-deletion');
});

// Legacy redirect
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user) {
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'doctor') return redirect()->route('doctor.dashboard');
        return redirect()->route('patient.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');
