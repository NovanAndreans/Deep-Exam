<?php

use App\Constants\Routes;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guest\GuestController;
use Illuminate\Support\Facades\Route;



Route::middleware('guest')->group(function () {
    Route::get('/', [GuestController::class, 'home'])->name(Routes::routeGuestHome);
    Route::get('/about', [GuestController::class, 'about'])->name(Routes::routeGuestHome);
    Route::get('/courses', [GuestController::class, 'courses'])->name(Routes::routeGuestHome);
    Route::get('/contact', [GuestController::class, 'contact'])->name(Routes::routeGuestHome);
    Route::get('/team', [GuestController::class, 'team'])->name(Routes::routeGuestHome);
    Route::get('/testimoni', [GuestController::class, 'testimoni'])->name(Routes::routeGuestHome);
    // Route::get('/not-found', [GuestController::class, 'notFound'])->name(Routes::routeGuestHome);

    Route::get('/signin', [AuthController::class, 'signin'])->name(Routes::routeSignin);
    Route::post('/signin', [AuthController::class, 'signinAction'])->name(Routes::routeSigninAction);
    Route::get('/signup', [AuthController::class, 'signup'])->name(Routes::routeSignup);
    Route::post('/signup', [AuthController::class, 'signupAction'])->name(Routes::routeSignupAction);
});

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'home'])->name(Routes::routeAdminDashboard);
});
