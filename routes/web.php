<?php

use Illuminate\Support\Facades\Route;

// Force redirect to filament dashboard for now
Route::redirect('/', '/admin');
