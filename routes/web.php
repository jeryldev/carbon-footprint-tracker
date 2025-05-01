<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\BaselineAssessmentController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Adjust the routes in routes/web.php to be more kid-friendly
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/mission-control', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Baseline Assessment
    Route::get('/planet-profile/create', [BaselineAssessmentController::class, 'create'])
        ->name('baseline-assessment.create');
    Route::post('/planet-profile', [BaselineAssessmentController::class, 'store'])
        ->name('baseline-assessment.store');
    Route::get('/planet-profile/edit', [BaselineAssessmentController::class, 'edit'])
        ->name('baseline-assessment.edit');
    Route::put('/planet-profile', [BaselineAssessmentController::class, 'update'])
        ->name('baseline-assessment.update');

    // Activity Logs
    Route::get('/planet-actions', [ActivityLogController::class, 'index'])
        ->name('activity-logs.index');
    Route::get('/planet-actions/new', [ActivityLogController::class, 'create'])
        ->name('activity-logs.create');
    Route::post('/planet-actions', [ActivityLogController::class, 'store'])
        ->name('activity-logs.store');
    Route::get('/planet-actions/{activityLog}/edit', [ActivityLogController::class, 'edit'])
        ->name('activity-logs.edit');
    Route::put('/planet-actions/{activityLog}', [ActivityLogController::class, 'update'])
        ->name('activity-logs.update');
    Route::delete('/planet-actions/{activityLog}', [ActivityLogController::class, 'destroy'])
        ->name('activity-logs.destroy');

    // Profile Management
    Route::get('/hero-profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/hero-profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/hero-profile', [ProfileController::class, 'destroy'])
        ->name('profile.delete');

    // Achievements
    Route::get('/achievements', [AchievementController::class, 'index'])
        ->middleware(['auth'])
        ->name('achievements.index');
});

require __DIR__.'/auth.php';
