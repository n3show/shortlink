<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RedirectController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/{shortCode}', RedirectController::class)
    ->where('shortCode', '[A-Za-z0-9]{6,10}')
    ->name('link.redirect');