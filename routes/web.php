<?php

use Illuminate\Support\Facades\Route;
// FIX: Import the controller so PHP knows where to find it
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// FIX: Return 'welcome' (the content), not 'layouts.master' (the skeleton)
Route::get('/', function () {
    return view('welcome');
})->name('home');

// FIX: Contact Routes
// The GET route shows the form
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
// The POST route handles the submission (Fixes the "405 Method Not Allowed" error)
Route::post('/contact', [ContactController::class, 'submit'])->name('contact.submit');

// FIX: Login Routes (Placeholder)
// These are required because your views use {{ route('login') }}
Route::get('/login', function () {
    return view('login'); // Matches resources/views/login.blade.php
})->name('login');

Route::post('/login', function () {
    return "Login Logic Not Implemented Yet";
});

// FIX: Dashboard Redirect (Placeholder)
Route::get('/dashboard', function () {
    // Return the patient dashboard view for testing purposes
    return view('patient.dashboard');
})->name('dashboard');