<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

class BaselineAssessmentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Skip for non-authenticated users or when accessing auth routes
        if (!$user ||
            Route::is('login') ||
            Route::is('register') ||
            Route::is('logout') ||
            Route::is('baseline-assessment.create') ||
            Route::is('baseline-assessment.store') ||
            Route::is('wiki.*') ||
            Route::is('profile.edit') ||
            Route::is('profile.update')
        ) {
            return $next($request);
        }

        // If user doesn't have a baseline assessment and trying to access restricted routes
        if (!$user->hasCompletedBaselineAssessment() &&
            (Route::is('dashboard') ||
             Route::is('activity-logs.*') ||
             Route::is('baseline-assessment.edit'))) {
            return redirect()->route('baseline-assessment.create')
                ->with('info', 'Please complete your baseline assessment first.');
        }

        return $next($request);
    }
}
