<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ImportController;
use Illuminate\Support\Facades\Route;

// Homepage (accessible to all)
Route::get('/', function () {
    return view('home');
})->name('home');

// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // User Management
    Route::resource('users', UserController::class);
    Route::get('users/{user}/change-password', [UserController::class, 'changePasswordForm'])->name('users.change-password');
    Route::post('users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.update-password');

    // Budget Management
    Route::get('budgets', [BudgetController::class, 'index'])->name('budgets.index');
    Route::get('budgets/upload', [BudgetController::class, 'uploadForm'])->name('budgets.upload-form');
    Route::post('budgets/upload', [BudgetController::class, 'upload'])->name('budgets.upload');

    // Approvals
    Route::resource('approvals', ApprovalController::class)->only(['index', 'create', 'store']);

    // Imports
    Route::get('imports', [ImportController::class, 'showImportForm'])->name('imports.index');
    Route::post('imports', [ImportController::class, 'import'])->name('imports.store');

    // Reports
    Route::get('reports', function () {
        return view('reports.index');
    })->name('reports.index');
});

// Include Authentication Routes
require __DIR__ . '/auth.php';
