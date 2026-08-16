<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\AuthController;
use Modules\User\Http\Controllers\DashboardController;
use Modules\User\Http\Controllers\UserController;

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('users', UserController::class)->names('user');
    Route::get('/invoice/pdf/{id?}', [UserController::class, 'generatePdf'])->name('invoice.pdf');
    });
    
Route::get('/invoice/csv/{id?}', [UserController::class, 'generateCsv'])->name('invoice.csv');
Route::get('/invoice/{id}/pdf', [UserController::class, 'generatePdf'])->name('invoice.pdf');   