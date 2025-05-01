<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\AccountHeadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;

// Homepage (accessible to all)
Route::get('/', function () {
    \Log::info('Root route accessed');
    return view('home');
})->name('home');

// Debug Session
Route::get('/debug-session', function () {
    Log::info('Debug session', [
        'user_id' => auth()->id(),
        'intended' => session()->get('url.intended'),
        'session' => session()->all(),
    ]);
    return response()->json([
        'user_id' => auth()->id(),
        'intended' => session()->get('url.intended'),
        'session' => session()->all(),
    ]);
})->name('debug.session');

// Check Admin Status
Route::get('/check-admin', function () {
    $user = auth()->user();
    Log::info('Check admin status', ['user_id' => $user->id, 'is_admin' => $user->isAdmin()]);
    return response()->json([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'is_admin' => $user->isAdmin(),
    ]);
})->name('check.admin')->middleware('auth');

// Authentication Routes
Route::get('/register', [LogInController::class, 'createRegister'])
    ->middleware('auth')
    ->name('register');

Route::post('/register', [LogInController::class, 'storeRegister'])
    ->middleware('auth')
    ->name('register.store');

Route::get('/login', [LogInController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/login', [LogInController::class, 'store'])
    ->middleware('guest')
    ->name('login.store');

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
    ->middleware('auth')
    ->name('password.confirm.store');

Route::post('/logout', [LogInController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Management
    Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update'])->middleware('admin');
    Route::get('/change-password', [UserController::class, 'changePasswordForm'])->name('users.change-password');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('users.update-password');
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    // Budget Management
    Route::get('budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('budgets/upload', [BudgetController::class, 'uploadForm'])->name('budgets.upload-form');
    Route::post('budgets/upload', [BudgetController::class, 'upload'])->name('budgets.upload');
    Route::get('budgets/import', [BudgetController::class, 'showImportForm'])->name('budgets.import.form');
    Route::post('budgets/import/estimated', [BudgetController::class, 'importEstimated'])->name('budgets.import.estimated');
    Route::post('budgets/import/revised', [BudgetController::class, 'importRevised'])->name('budgets.import.revised');
    Route::patch('budgets/{budget}/revise', [BudgetController::class, 'revise'])->name('budgets.revise');

    // Expenses (previously Approvals)
    Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store']);
    Route::post('expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
    Route::post('expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');

    // Imports (Restricted to Admins)
    Route::middleware('admin')->group(function () {
        Route::get('imports', [ImportController::class, 'showImportForm'])->name('imports.index');
        Route::post('imports', [ImportController::class, 'import'])->name('imports.store');
    });

    // Reports
    Route::get('reports', function () {
        return view('reports.index');
    })->name('reports.index');

    // Account Heads (Admin Only)
    Route::middleware('admin')->group(function () {
        Route::get('accounts', [AccountHeadController::class, 'index'])->name('accounts.index');
        Route::get('accounts/create', [AccountHeadController::class, 'create'])->name('accounts.create');
        Route::post('accounts', [AccountHeadController::class, 'store'])->name('accounts.store');
        Route::get('accounts/{accountHead}', [AccountHeadController::class, 'show'])->name('accounts.show');
        Route::get('accounts/{accountHead}/edit', [AccountHeadController::class, 'edit'])->name('accounts.edit');
        Route::put('accounts/{accountHead}', [AccountHeadController::class, 'update'])->name('accounts.update');
        Route::get('accounts/import/form', [AccountHeadController::class, 'importForm'])->name('accounts.import.form');
        Route::post('accounts/import', [AccountHeadController::class, 'import'])->name('accounts.import');
    });
});
