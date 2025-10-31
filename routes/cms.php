<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cms\DashboardController;

Route::get('dashboard',         [DashboardController::class,'dashboard'])->name('dashboard');
