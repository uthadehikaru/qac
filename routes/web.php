<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

Route::middleware(['auth', 'roles:admin'])->namespace('App\Http\Controllers\Admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('/members', MemberController::class);
    Route::resource('/courses', CourseController::class);
    Route::resource('/courses/{course_id}/batches', BatchController::class);
});

Route::middleware(['auth', 'roles:member'])->namespace('App\Http\Controllers\Member')->prefix('member')->name('member.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

require __DIR__.'/auth.php';
