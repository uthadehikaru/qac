<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Member\DashboardController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\BatchMemberController;
use App\Http\Controllers\Member\BatchController as MBatchController;
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

Route::get('/', [HomeController::class, 'index']);

Route::middleware(['auth', 'verified', 'roles:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('members', MemberController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('courses.batches', BatchController::class);
    Route::get('coureses/{course}/batches/{batch}/members', [MemberBatchController::class, 'index'])->name('courses.batches.members');
    Route::get('coureses/{course}/batches/{batch}/members/create', [MemberBatchController::class, 'create'])->name('courses.batches.members.create');
    Route::post('coureses/{course}/batches/{batch}/members/update', [MemberBatchController::class, 'store'])->name('courses.batches.members.update');
    Route::get('coureses/{course}/batches/{batch}/members/{id}', [MemberBatchController::class, 'approve'])->name('courses.batches.members.approve');
    Route::delete('coureses/{course}/batches/{batch}/members/{id}', [MemberBatchController::class, 'destroy'])->name('courses.batches.members.delete');
});

Route::middleware(['auth', 'roles:member'])->prefix('member')->name('member.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/courses', [BatchMemberController::class, 'index'])->name('batches');
    Route::get('/courses/{member_batch_id}', [BatchMemberController::class, 'detail'])->name('batches.detail');
    Route::get('/batch/{id}', [MBatchController::class, 'detail'])->name('batch.detail');
    Route::post('/batch/{id}/register', [MBatchController::class, 'register'])->name('batch.register');
});

require __DIR__.'/auth.php';
