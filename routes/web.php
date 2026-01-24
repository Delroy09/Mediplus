<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AdminController;

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

// ============================================
// V2 Routes (A/B Testing - New UI)
// ============================================
Route::get('/v2', function () {
    return view('NewUI.home_v2');
})->name('home.v2');

Route::get('/v2/contact', function () {
    return view('NewUI.contact_v2');
})->name('contact.v2');

// V2 Contact form submission (uses same controller)
Route::post('/v2/contact', [ContactController::class, 'submit'])->name('contact.v2.submit');

// V2 Login Routes
Route::get('/v2/login', function () {
    return view('NewUI.login_v2');
})->name('login.v2');

Route::post('/v2/login', function (\Illuminate\Http\Request $request) {
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
})->name('login.v2.submit');

// V2 Doctor Login
Route::get('/v2/doctor/login', function () {
    return view('NewUI.doctor.login_v2');
})->name('doctor.login.v2');

Route::post('/v2/doctor/login', function (\Illuminate\Http\Request $request) {
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
})->name('doctor.login.v2.submit');

// Login Routes
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect based on role
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

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');

// Doctor Login Portal (Separate from patient login)
Route::get('/doctor/login', function () {
    return view('doctor.login');
})->name('doctor.login');

Route::post('/doctor/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $user = Auth::user();

        // Only allow doctors to login through this portal
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

// Admin Routes (Open for testing - no auth required)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/approve/{id}', [AdminController::class, 'approveRequest'])->name('approve');
    Route::post('/reject/{id}', [AdminController::class, 'rejectRequest'])->name('reject');
    Route::post('/reassign-doctor/{id}', [AdminController::class, 'reassignDoctor'])->name('reassign-doctor');
});

// Patient Routes (Protected)
Route::prefix('patient')->name('patient.')->middleware('auth')->group(function () {
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [PatientController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [PatientController::class, 'updateProfile'])->name('profile.update');
    Route::get('/schedule', [PatientController::class, 'schedule'])->name('schedule');
    Route::get('/manage', [PatientController::class, 'manage'])->name('manage');
    Route::post('/request-deletion', [PatientController::class, 'requestDeletion'])->name('request-deletion');
});

// Doctor Routes (Protected)
Route::prefix('doctor')->name('doctor.')->middleware('auth')->group(function () {
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
