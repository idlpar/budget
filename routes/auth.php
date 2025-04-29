<?php

use App\Http\Controllers\LogInController;
use Illuminate\Support\Facades\Route;

Route::get('/register', [LogInController::class, 'createRegister'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [LogInController::class, 'storeRegister'])
    ->middleware('guest');

Route::get('/login', [LogInController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LogInController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [LogInController::class, 'createForgotPassword'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [LogInController::class, 'storeForgotPassword'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [LogInController::class, 'createResetPassword'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [LogInController::class, 'storeResetPassword'])
    ->middleware('guest')
    ->name('password.update');

Route::get('/verify-email', [LogInController::class, 'showVerificationPrompt'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [LogInController::class, 'verifyEmail'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [LogInController::class, 'sendVerificationEmail'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [LogInController::class, 'showConfirmPassword'])
    ->middleware('auth')
    ->name('password.confirm');

Route::post('/confirm-password', [LogInController::class, 'storeConfirmPassword'])
    ->middleware('auth');

Route::post('/logout', [LogInController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');
