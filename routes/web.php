<?php

use App\Constants\Routes;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Settings\{
    FileController,
    PermissionController,
    TypeController
};
use App\Http\Controllers\Admin\Masters\{
    LessonController,
    MeetingController,
    RpsController,
    SubCpmkController,
    UserController
};
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guest\GuestController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [GuestController::class, 'home'])->name(Routes::routeGuestHome);
    Route::get('/about', [GuestController::class, 'about'])->name(Routes::routeGuestAbout);
    Route::get('/courses', [GuestController::class, 'courses'])->name(Routes::routeGuestCourses);
    Route::get('/contact', [GuestController::class, 'contact'])->name(Routes::routeGuestContact);
    Route::get('/team', [GuestController::class, 'team'])->name(Routes::routeGuestTeam);
    Route::get('/testimoni', [GuestController::class, 'testimoni'])->name(Routes::routeGuestTestimoni);
    Route::get('/not-found', [GuestController::class, 'notFound'])->name(Routes::routeGuest404);

    Route::get('/signin', [AuthController::class, 'signin'])->name(Routes::routeSignin);
    Route::post('/signin', [AuthController::class, 'signinAction'])->name(Routes::routeSigninAction);
    Route::get('/signup', [AuthController::class, 'signup'])->name(Routes::routeSignup);
    Route::post('/signup', [AuthController::class, 'signupAction'])->name(Routes::routeSignupAction);
});

Route::middleware('auth:web')->group(function () {
    Route::get('/signout', [AuthController::class, 'signout'])->name(Routes::routeSignout);

    Route::get('/dashboard', [AdminController::class, 'home'])->name(Routes::routeAdminDashboard);

    Route::resource('quiz', QuizController::class);
    Route::get('quiz/{id}/progress', [QuizController::class, 'progress'])->name(Routes::routeQuizProgress);
    Route::get('quiz/progress/result', [QuizController::class, 'result'])->name(Routes::routeQuizResult);

    Route::group(['prefix' => 'masters'], function () {
        Route::resource('users', UserController::class);

        Route::resource('rps', RpsController::class);
        Route::get('rps/detail/{id}', [RpsController::class, 'subCpmkView'])->name('rps.subCpmk');

        Route::resource('subcpmk', SubCpmkController::class);
        Route::resource('meeting', MeetingController::class);
        Route::get('meeting/generate-kisi/{id}', [MeetingController::class, 'generateKisi'])->name('meeting.generate-kisi');
    });

    Route::group(['prefix' => 'settings'], function () {
        Route::resource('permissions', PermissionController::class);
        Route::post('permissions/toggle', [PermissionController::class, 'togglePermission'])->name('permission.toggle');

        Route::resource('types', TypeController::class);

        Route::resource('files', FileController::class);
    });
});
