<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BaselineAssessmentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Baseline Assessment
    Route::get('/baseline/create', [BaselineAssessmentController::class, 'create'])->name('baseline-assessment.create');
    Route::post('/baseline', [BaselineAssessmentController::class, 'store'])->name('baseline-assessment.store');
    Route::get('/baseline/edit', [BaselineAssessmentController::class, 'edit'])->name('baseline-assessment.edit');
    Route::put('/baseline', [BaselineAssessmentController::class, 'update'])->name('baseline-assessment.update');

    // Activity Logs
    Route::get('/activities', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activities/create', [ActivityLogController::class, 'create'])->name('activity-logs.create');
    Route::post('/activities', [ActivityLogController::class, 'store'])->name('activity-logs.store');
    Route::get('/activities/{activityLog}/edit', [ActivityLogController::class, 'edit'])->name('activity-logs.edit');
    Route::put('/activities/{activityLog}', [ActivityLogController::class, 'update'])->name('activity-logs.update');
    Route::delete('/activities/{activityLog}', [ActivityLogController::class, 'destroy'])->name('activity-logs.destroy');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.delete');
});

require __DIR__.'/auth.php';
