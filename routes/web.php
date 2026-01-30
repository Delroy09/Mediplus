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

// Show home page
Route::get('/', function () {
    return view('home_v2');
})->name('home');

// Show contact form
Route::get('/contact', function () {
    return view('contact_v2');
})->name('contact');

// Handle contact form submit (user types and submits form)
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// Show login page
Route::get('/login', function () {
    return view('login_v2');
})->name('login');

// Handle login form submit (checks user credentials)
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

// Show doctor login page
Route::get('/doctor/login', function () {
    return view('doctor.login_v2');
})->name('doctor.login');

// Handle doctor login form submit (checks doctor credentials)
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

// Logout user and end session
Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Patient dashboard and profile routes (user must be logged in)
Route::prefix('patient')->name('patient.')->middleware('auth')->group(function () {
    // Show patient dashboard
    Route::get('/dashboard', [PatientController::class, 'dashboardV2'])->name('dashboard');
    // Show and update patient profile
    Route::get('/profile', [PatientController::class, 'profileV2'])->name('profile');
    Route::post('/profile', [PatientController::class, 'updateProfileV2'])->name('profile.update');
    // Show patient schedule
    Route::get('/schedule', [PatientController::class, 'scheduleV2'])->name('schedule');
    // Show patient management page
    Route::get('/manage', [PatientController::class, 'manageV2'])->name('manage');
    // Handle patient account deletion request
    Route::post('/request-deletion', [PatientController::class, 'requestDeletionV2'])->name('request-deletion');
});

// Doctor dashboard and patient management routes (user must be logged in)
Route::prefix('doctor')->name('doctor.')->middleware('auth')->group(function () {
    // Show doctor dashboard
    Route::get('/dashboard', [DoctorController::class, 'dashboardV2'])->name('dashboard');
    // List assigned patients
    Route::get('/patients', [DoctorController::class, 'patientsV2'])->name('patients');
    // View patient details
    Route::get('/patient/{id}', [DoctorController::class, 'viewPatientV2'])->name('patient.view');
    // Show and handle patient status update
    Route::get('/patient/{id}/update-status', [DoctorController::class, 'updateStatusFormV2'])->name('patient.update-status');
    Route::post('/patient/{id}/update-status', [DoctorController::class, 'updateStatusV2'])->name('patient.update-status.post');
    // Show and handle adding a medical record
    Route::get('/patient/{id}/add-record', [DoctorController::class, 'createMedicalRecordV2'])->name('patient.create-record');
    Route::post('/patient/{id}/add-record', [DoctorController::class, 'storeMedicalRecordV2'])->name('patient.create-record.post');
    // Show doctor schedule
    Route::get('/schedule', [DoctorController::class, 'scheduleV2'])->name('schedule');
    // Show doctor profile
    Route::get('/profile', [DoctorController::class, 'profileV2'])->name('profile');
});

// Admin dashboard and management routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Show admin dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboardV2'])->name('dashboard');
    // Approve or reject account requests
    Route::post('/approve/{id}', [AdminController::class, 'approveRequest'])->name('approve');
    Route::post('/reject/{id}', [AdminController::class, 'rejectRequest'])->name('reject');

    // Doctor management CRUD
    Route::get('/doctors', [AdminController::class, 'doctorsV2'])->name('doctors');
    Route::get('/doctor/create', [AdminController::class, 'createDoctorV2'])->name('doctor.create');
    Route::post('/doctor', [AdminController::class, 'storeDoctor'])->name('doctor.store');
    Route::get('/doctor/{id}', [AdminController::class, 'viewDoctorV2'])->name('doctor.view');
    Route::get('/doctor/{id}/edit', [AdminController::class, 'editDoctorV2'])->name('doctor.edit');
    Route::put('/doctor/{id}', [AdminController::class, 'updateDoctor'])->name('doctor.update');
    Route::delete('/doctor/{id}', [AdminController::class, 'deleteDoctor'])->name('doctor.delete');

    // Patient management CRUD
    Route::get('/patients', [AdminController::class, 'patientsV2'])->name('patients');
    Route::get('/patient/{id}', [AdminController::class, 'viewPatientV2'])->name('patient.view');
    Route::get('/patient/{id}/assign', [AdminController::class, 'assignPatientV2'])->name('patient.assign');
    Route::post('/patient/{id}/assign', [AdminController::class, 'assignPatientPost'])->name('patient.assign.post');

    // Assignment management
    Route::get('/assignments', [AdminController::class, 'assignmentsV2'])->name('assignments');
    Route::post('/assignment', [AdminController::class, 'storeAssignment'])->name('assignment.store');
    Route::delete('/assignment/{id}', [AdminController::class, 'deleteAssignment'])->name('assignment.delete');

    // Handle patient deletion requests
    Route::post('/approve-deletion/{id}', [AdminController::class, 'approveDeletion'])->name('approve-deletion');
    Route::post('/reject-deletion/{id}', [AdminController::class, 'rejectDeletion'])->name('reject-deletion');
});

// Redirect user to their dashboard after login
Route::get('/dashboard', function () {
    $user = Auth::user();
    if ($user) {
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'doctor') return redirect()->route('doctor.dashboard');
        return redirect()->route('patient.dashboard');
    }
    return redirect()->route('login');
})->name('dashboard');
