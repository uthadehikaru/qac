<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\BatchMemberController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\MemberBatchController;

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
Route::get('/about', function () {
    return view('about');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth','verified'])->name('dashboard');

Route::middleware(['auth', 'roles:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('members', MemberController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('courses.batches', BatchController::class);
    Route::get('coureses/{course}/batches/{batch}/members', [MemberBatchController::class, 'index'])->name('courses.batches.members');
    Route::get('coureses/{course}/batches/{batch}/members/create', [MemberBatchController::class, 'create'])->name('courses.batches.members.create');
    Route::post('coureses/{course}/batches/{batch}/members/create', [MemberBatchController::class, 'store'])->name('courses.batches.members.update');
    Route::get('coureses/{course}/batches/{batch}/members/{id}', [MemberBatchController::class, 'update'])->name('courses.batches.members.update');
});

Route::middleware(['auth', 'roles:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/batches', [BatchMemberController::class, 'index'])->name('batches');
});

require __DIR__.'/auth.php';
