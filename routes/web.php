<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('layouts.master');
});


Route::get('/w', function () {
    return view('welcome');
});