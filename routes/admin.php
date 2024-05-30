<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\PlanController;
use App\Http\Controllers\Admin\ContentController;


Route::resource('user', UserController::class)->except(['create', 'edit', 'show']);
Route::get('/users', [UserController::class, 'getUsers'])->name('getUsers');
Route::get('/user/one/{id}', [UserController::class, 'getOne'])->name('user.getOne');


Route::resource('course', CourseController::class)->except(['create', 'edit', 'show']);
Route::get('/courses', [CourseController::class, 'getCourses'])->name('getCourses');
Route::get('/course/one/{id}', [CourseController::class, 'getOne'])->name('course.getOne');


Route::get('/plan/{courseId}', [PlanController::class, 'index'])->name('plan.index');
//Route::resource('plan', PlanController::class)->except(['create', 'edit', 'show']);
Route::post('/plan/create', [PlanController::class, 'store'])->name('plan.store');
Route::get('/plan/one/{id}', [PlanController::class, 'getOne'])->name('plan.getOne');
Route::get('/plan/edit/{id}', [PlanController::class, 'update'])->name('plan.update');
Route::delete('/plan/delete/{id}', [PlanController::class, 'destroy'])->name('plan.destroy');


//Route::resource('content', ContentController::class)->except(['create', 'edit', 'show']);
//Route::get('/contents', [ContentController::class, 'getContents'])->name('getContents');
//Route::get('/content/one/{id}', [ContentController::class, 'getOne'])->name('plan.getOne');
