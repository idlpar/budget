<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\AccountHeadController;
use App\Http\Controllers\OrganogramController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;
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
    Log::info('Check admin status', [
        'user_id' => $user->id,
        'is_admin' => $user->is_admin,
        'division_id' => $user->division_id,
        'department_id' => $user->department_id,
        'section_id' => $user->section_id,
    ]);
    return response()->json([
        'user_id' => $user->id,
        'name' => $user->name,
        'email' => $user->email,
        'is_admin' => $user->is_admin,
        'division_id' => $user->division_id,
        'department_id' => $user->department_id,
        'section_id' => $user->section_id,
    ]);
})->name('check.admin')->middleware('auth');

// Authentication Routes
Route::middleware('auth', 'admin')->group(function () {
    Route::get('/register', [LogInController::class, 'createRegister'])->name('register');
    Route::post('/register', [LogInController::class, 'storeRegister'])->name('register.store');
});

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

    // User Management (Admin only)
    Route::middleware('admin')->group(function () {
        Route::resource('users', UserController::class)->only(['index', 'create', 'store', 'show', 'edit', 'update']);
    });
    Route::get('/change-password', [UserController::class, 'changePasswordForm'])->name('users.change-password');
    Route::post('/change-password', [UserController::class, 'changePassword'])->name('users.update-password');
    Route::get('/profile', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::delete('/profile', [UserController::class, 'destroy'])->name('profile.destroy');

    // Budget Imports (Admin only) - Moved before the hierarchy group to avoid route conflict
    Route::middleware('admin')->group(function () {
        Route::get('budgets/import', [BudgetController::class, 'showImportForm'])->name('budgets.import.form');
        Route::post('budgets/import/estimated', [BudgetController::class, 'importEstimated'])->name('budgets.import.estimated');
        Route::post('budgets/import/revised', [BudgetController::class, 'importRevised'])->name('budgets.import.revised');
    });

    // Budget Management (Accessible to all, scoped by hierarchy)
    Route::middleware('hierarchy')->group(function () {
        Route::get('budgets', [BudgetController::class, 'index'])->name('budgets.index');
        Route::get('budgets/{budget}', [BudgetController::class, 'show'])->name('budgets.show');
        Route::get('budgets/{budget}/edit', [BudgetController::class, 'edit'])->name('budgets.edit');
        Route::put('budgets/{budget}', [BudgetController::class, 'update'])->name('budgets.update');
        Route::get('budgets/upload/form', [BudgetController::class, 'uploadForm'])->name('budgets.upload-form');
        Route::post('budgets/upload', [BudgetController::class, 'upload'])->name('budgets.upload');
        Route::patch('budgets/{budget}/revise', [BudgetController::class, 'revise'])->name('budgets.revise');
    });

    // Expenses (Accessible to all, scoped by hierarchy)
    Route::middleware('hierarchy')->group(function () {
        Route::resource('expenses', ExpenseController::class)->only(['index', 'create', 'store']);
        Route::post('expenses/{expense}/approve', [ExpenseController::class, 'approve'])->name('expenses.approve');
        Route::post('expenses/{expense}/reject', [ExpenseController::class, 'reject'])->name('expenses.reject');
    });

    // Imports (Admin only)
    Route::middleware('admin')->group(function () {
        Route::get('imports', [ImportController::class, 'showImportForm'])->name('imports.index');
        Route::post('imports', [ImportController::class, 'import'])->name('imports.store');
    });

    // Reports (Accessible to all, scoped by hierarchy)
    Route::middleware('hierarchy')->group(function () {
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/expense', [ReportController::class, 'expense'])->name('reports.expense');
        Route::get('reports/account-head/{accountHead}', [ReportController::class, 'accountHeadDetail'])->name('reports.account-head');
    });

    // Account Heads (CRUD by all, import by admin)
    Route::middleware('admin')->group(function () {
        Route::get('accounts/import/form', [AccountHeadController::class, 'importForm'])->name('accounts.import.form');
        Route::post('accounts/import', [AccountHeadController::class, 'import'])->name('accounts.import');
    });
    Route::middleware('hierarchy')->group(function () {
        Route::get('accounts', [AccountHeadController::class, 'index'])->name('accounts.index');
        Route::get('accounts/create', [AccountHeadController::class, 'create'])->name('accounts.create');
        Route::post('accounts', [AccountHeadController::class, 'store'])->name('accounts.store');
        Route::get('accounts/{accountHead}', [AccountHeadController::class, 'show'])->name('accounts.show');
        Route::get('accounts/{accountHead}/edit', [AccountHeadController::class, 'edit'])->name('accounts.edit');
        Route::put('accounts/{accountHead}', [AccountHeadController::class, 'update'])->name('accounts.update');
    });

    // Organogram Management (CRUD by all, import by admin)
    Route::middleware('admin')->group(function () {
        Route::get('organogram/upload', [OrganogramController::class, 'uploadForm'])->name('organogram.upload');
        Route::post('organogram/upload', [OrganogramController::class, 'upload'])->name('organogram.upload.store');
    });
    Route::middleware('hierarchy')->group(function () {
        Route::get('organogram', [OrganogramController::class, 'index'])->name('organogram.index');
        Route::get('organogram/create', [OrganogramController::class, 'create'])->name('organogram.create');
        Route::post('organogram', [OrganogramController::class, 'store'])->name('organogram.store');
        Route::get('organogram/{type}/{id}/edit', [OrganogramController::class, 'edit'])->name('organogram.edit');
        Route::put('organogram/{type}/{id}', [OrganogramController::class, 'update'])->name('organogram.update');
        Route::delete('organogram/{type}/{id}', [OrganogramController::class, 'destroy'])->name('organogram.destroy');
        Route::get('organogram/{type}/{id}/show', [OrganogramController::class, 'show'])->name('organogram.show');
    });

    // Transaction Management (Accessible to all, scoped by hierarchy)
    Route::middleware('hierarchy')->group(function () {
        Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
        Route::get('transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
        Route::post('transactions', [TransactionController::class, 'store'])->name('transactions.store');
    });
});

// API Routes for Dynamic Loading
Route::middleware('auth')->group(function () {
    Route::get('/api/divisions/{division}/departments', function (App\Models\Division $division) {
        return response()->json($division->departments);
    });

    Route::get('/api/departments/{department}/sections', function (App\Models\Department $department) {
        return response()->json($department->sections);
    });
});

Route::get('/api/account-heads/{accountHeadId}/remaining-budget', [ExpenseController::class, 'getRemainingBudget']);
Route::get('/api/divisions/{divisionId}/departments', [OrganogramController::class, 'getDepartments']);
Route::get('/api/departments/{departmentId}/sections', [OrganogramController::class, 'getSections']);
