<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\OrderActionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\OrderFileController;
use App\Http\Controllers\ContentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (!Auth::check()) {
        return redirect('login');
    }
    if(Auth::user()->rule === 1) { // admin
        return redirect()->intended('/home');
    }
    // student
    return redirect()->intended('home');
});

Route::get('login', function () {
    return view('auth.login');
});

Route::get('registration', function () {
    return view('auth.registration');
})->name('registration');
Route::post('registration', [AuthController::class, 'registration'])->name('registration.store');

Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware(['auth', 'isActive'])->group(function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    // Course
    Route::get('/course/{id}', [CourseController::class, 'index'])->name('course.index');
    Route::get('/course/{courseId}/{planId}', [CourseController::class, 'getContent'])
        ->name('course.getContent');


    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    // user profile
    Route::post('/user/profile', [AuthController::class, 'profile'])->name('user.profile');
    Route::get('locale/{lang}', [LocaleController::class, 'lang'])->name('locale');
});
