<?php

use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

// Force redirect to filament dashboard for now
Route::redirect('/', '/admin');

