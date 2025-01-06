<?php

use App\Constants\Routes;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('GuestPages.index');
})->name(Routes::routeGuestHome);
Route::get('/about', function () {
    return view('GuestPages.about');
})->name(Routes::routeGuestAbout);
Route::get('/courses', function () {
    return view('GuestPages.courses');
})->name(Routes::routeGuestCourses);
Route::get('/contact', function () {
    return view('GuestPages.contact');
})->name(Routes::routeGuestContact);
Route::get('/team', function () {
    return view('GuestPages.team');
})->name(Routes::routeGuestTeam);
Route::get('/testimoni', function () {
    return view('GuestPages.testimoni');
})->name(Routes::routeGuestTestimoni);
Route::get('/404', function () {
    return view('GuestPages.404');
})->name(Routes::routeGuest404);

