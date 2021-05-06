<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Member\DashboardController as MDashboardController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\BatchMemberController;
use App\Http\Controllers\Member\BatchController as MBatchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\MemberBatchController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\TestimonialController;

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
Route::get('/events', [EventController::class, 'index'])->name('event.list');
Route::get('/event/{slug}', [EventController::class, 'detail'])->name('event.detail');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/read', [NotificationController::class, 'read'])->name('notifications.read');
    
    Route::middleware(['roles:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('members/verify/{id}', [MemberController::class, 'verify'])->name('members.verify');
        Route::resource('members', MemberController::class);
        Route::resource('courses', CourseController::class);
        Route::resource('courses.batches', BatchController::class);
        Route::resource('events', AdminEventController::class);
        Route::resource('systems', SystemController::class);
        Route::get('testimonials/{id}/delete', [TestimonialController::class, 'delete'])->name('testimonials.delete');
        Route::resource('testimonials', TestimonialController::class);
        Route::get('courses/{course}/batches/{batch}/members', [MemberBatchController::class, 'index'])->name('courses.batches.members');
        Route::get('courses/{course}/batches/{batch}/members/create', [MemberBatchController::class, 'create'])->name('courses.batches.members.create');
        Route::post('courses/{course}/batches/{batch}/members/create', [MemberBatchController::class, 'store'])->name('courses.batches.members.store');
        Route::get('courses/{course}/batches/{batch}/members/{id}', [MemberBatchController::class, 'edit'])->name('courses.batches.members.edit');
        Route::post('courses/{course}/batches/{batch}/members/{id}', [MemberBatchController::class, 'update'])->name('courses.batches.members.update');
        Route::delete('courses/{course}/batches/{batch}/members/{id}', [MemberBatchController::class, 'destroy'])->name('courses.batches.members.delete');
    });

    Route::middleware(['roles:member'])->prefix('member')->name('member.')->group(function () {
        Route::get('/dashboard', [MDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
        Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::get('/courses', [BatchMemberController::class, 'index'])->name('batches');
        Route::get('/courses/{member_batch_id}', [BatchMemberController::class, 'detail'])->name('batches.detail');
        Route::get('/batch/{id}', [MBatchController::class, 'detail'])->name('batch.detail');
        Route::post('/batch/{id}/register', [MBatchController::class, 'register'])->name('batch.register');
    });
});

require __DIR__.'/auth.php';
