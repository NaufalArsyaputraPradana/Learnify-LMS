<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Instructor\CourseController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Admin Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->middleware('role:admin')
        ->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('categories', CategoryController::class)
                ->except(['show']);
        });

    /*
    |--------------------------------------------------------------------------
    | Instructor Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('instructor')
        ->name('instructor.')
        ->middleware('role:instructor')
        ->group(function () {
            Route::get('/dashboard', [InstructorDashboardController::class, 'index'])
                ->name('dashboard');

            Route::resource('courses', CourseController::class)
                ->except(['show']);
        });

    /*
    |--------------------------------------------------------------------------
    | Student Routes
    |--------------------------------------------------------------------------
    */

    Route::prefix('student')
        ->name('student.')
        ->middleware('role:student')
        ->group(function () {
            Route::get('/dashboard', [StudentDashboardController::class, 'index'])
                ->name('dashboard');
        });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__ . '/auth.php';