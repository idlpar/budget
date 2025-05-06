<?php
//
//use App\Http\Controllers\ExpenseController;
//use App\Http\Controllers\OrganogramController;
//use Illuminate\Support\Facades\Route;
//
//Route::middleware(['auth'])->prefix('api')->group(function () {
//    Route::get('/divisions/{division}/departments', function (\App\Models\Division $division) {
//        return $division->departments()->select('id', 'name')->get();
//    })->name('api.divisions.departments');
//
//    Route::get('/departments/{department}/sections', function (\App\Models\Department $department) {
//        return $department->sections()->select('id', 'name')->get();
//    })->name('api.departments.sections');
//
//    Route::get('/sections/{section}', [OrganogramController::class, 'getSectionDetails'])->name('api.sections.details');
//    Route::get('/departments/{department}', [OrganogramController::class, 'getDepartmentDetails'])->name('api.departments.details');
//
//    Route::get('/account-heads/{accountHeadId}/remaining-budget', [ExpenseController::class, 'getRemainingBudget'])->name('api.account-heads.remaining-budget');
//});
