<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BaselineAssessmentController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    return view('dashboard', [
        'hasBaselineAssessment' => $user->hasCompletedBaselineAssessment(),
        'baselineAssessment' => $user->baselineAssessment
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Baseline Assessment Routes
    Route::get('/baseline-assessment', [BaselineAssessmentController::class, 'create'])->name('baseline-assessment.create');
    Route::post('/baseline-assessment', [BaselineAssessmentController::class, 'store'])->name('baseline-assessment.store');

    // Activity Log Routes
    Route::resource('activity-logs', ActivityLogController::class)->except(['show']);
});

require __DIR__.'/auth.php';
