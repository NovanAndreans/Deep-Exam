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
use App\Http\Controllers\QuizProgressController;
use App\Http\Controllers\QuizSettingController;
use App\Http\Controllers\QuizType3Controller;
use App\Http\Controllers\QuizType4Controller;
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
    Route::post('quiz/progress/submittype2', [QuizProgressController::class, 'storeType2'])->name(Routes::routeQuizSubmitType2);
    Route::get('quiz/progress/result', [QuizController::class, 'result'])->name(Routes::routeQuizResult);

    Route::resource('quiz3', QuizType3Controller::class);
    Route::get('quiz3/{id}/progress-type3', [QuizType3Controller::class, 'progress'])->name(Routes::routeQuizType3Progress);
    Route::post('quiz3/progress/submittype3', [QuizProgressController::class, 'storeType3'])->name(Routes::routeQuizSubmitType3);
    Route::get('quiz3/progress/result', [QuizType3Controller::class, 'result'])->name(Routes::routeQuizResult3);
    
    Route::resource('quiz4', QuizType4Controller::class);
    Route::get('quiz4/{id}/progress-type4', [QuizType4Controller::class, 'progress'])->name(Routes::routeQuizType4Progress);
    Route::post('quiz4/progress/submittype4', [QuizProgressController::class, 'storeType4'])->name(Routes::routeQuizSubmitType4);
    Route::get('quiz4/progress/result', [QuizType4Controller::class, 'result'])->name(Routes::routeQuizResult4);

    Route::get('quizes/generate-questions', [QuizController::class, 'generateQuestion'])->name(Routes::routeQuizGenerate);

    Route::group(['prefix' => 'masters'], function () {
        Route::resource('users', UserController::class);

        Route::resource('rps', RpsController::class);
        Route::get('rps/detail/{id}', [RpsController::class, 'subCpmkView'])->name('rps.subCpmk');

        Route::resource('quiz_setting', QuizSettingController::class);
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
