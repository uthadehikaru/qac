<?php

use App\Http\Controllers\Admin\AddSubscriberFromBatch;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\Member\DashboardController as MDashboardController;
use App\Http\Controllers\Member\ProfileController;
use App\Http\Controllers\Member\PasswordController;
use App\Http\Controllers\Member\BatchMemberController;
use App\Http\Controllers\Member\BatchController as MBatchController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\MemberBatchController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\Admin\QuizController as AdminQuizController;
use App\Http\Controllers\Admin\ParticipantController as AdminParticipantController;
use App\Http\Controllers\Admin\SystemController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\EcoursesController;
use App\Http\Controllers\Admin\QueueController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\LessonsController;
use App\Http\Controllers\Admin\LoginAsUser;
use App\Http\Controllers\Admin\PublishEcourse;
use App\Http\Controllers\Admin\SectionsController;
use App\Http\Controllers\Admin\SubscriptionsController;
use App\Http\Controllers\EcourseController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Member\CompleteLesson;
use App\Http\Controllers\Member\LessonVideo;
use App\Http\Controllers\Member\MemberEcoursesController;
use App\Http\Controllers\UploadController;

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

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/events', [EventController::class, 'index'])->name('event.list');
Route::get('/event/{slug}', [EventController::class, 'detail'])->name('event.detail');
Route::get('/testimonials', [HomeController::class, 'testimonials'])->name('testimonials');
Route::get('/sertifikat/{id}', [HomeController::class, 'certificate'])->name('certificate');
Route::get('/login/otp', [OtpController::class, 'index'])->name('auth.otp');
Route::post('/login/otp/send', [OtpController::class, 'request'])->name('auth.otp.request');
Route::post('/login/otp', [OtpController::class, 'check']);
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.list');
Route::get('/quiz/{quiz:slug}', [QuizController::class, 'detail'])->name('quiz.detail');
Route::post('/quiz/{quiz:slug}/finish', [QuizController::class, 'finish'])->name('quiz.finish');
Route::post('/quiz/{quiz:slug}/apply', [QuizController::class, 'apply'])->name('quiz.apply');
Route::get('/quiz/{session}/verify', [QuizController::class, 'verify'])->name('quiz.verify');
Route::resource('ecourses', EcourseController::class)
    ->only(['index','show'])
    ->parameters([
        'ecourses' => 'ecourse:slug',
    ]);

Route::get('checkout/{ecourse:slug}', [CheckoutController::class, 'index'])->name('checkout');

Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::get('/notifications/read', [NotificationController::class, 'read'])->name('notifications.read');
    Route::post('/upload/{table}/{id}', UploadController::class)->name('upload');
    
    Route::middleware(['roles:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/retry', [JobController::class, 'retry'])->name('jobs.retry');
        Route::get('/jobs/empty', [JobController::class, 'empty'])->name('jobs.empty');
        Route::get('/logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class,'index'])->name('logs');
        Route::get('/login-as/{user:id}', LoginAsUser::class)->name('login.as');

        // MEMBERS
        Route::get('members/verify/{id}', [MemberController::class, 'verify'])->name('members.verify');
        Route::get('members/reset/{id}', [MemberController::class, 'reset'])->name('members.reset');
        Route::resource('members', MemberController::class);

        // COURSES
        Route::get('courses/members/{course_id}', [CourseController::class, 'members'])->name('courses.members');
        Route::resource('courses', CourseController::class);

        // BATCHES
        Route::get('/courses/{course_id}/batches/{id}/invite/waitinglist', [BatchController::class,'inviteWaitingList'])->name('courses.batches.invite.waitinglist');
        Route::resource('courses.batches', BatchController::class);
        
        // QUEUES
        Route::get('/courses/{course_id}/queues/{id}/register', [QueueController::class,'register'])->name('courses.queues.register');
        Route::resource('courses.queues', QueueController::class);

        // MODULES
        Route::resource('courses.modules', ModuleController::class);
        
        // EVENTS
        Route::get('events/{id}/share', [AdminEventController::class, 'share'])->name('events.share');
        Route::resource('events', AdminEventController::class);

        // QUIZ
        Route::get('quiz/{id}/questions', [AdminQuizController::class, 'questions'])->name('quiz.questions');
        Route::get('quiz/{quiz}/questions/{question}', [AdminQuizController::class, 'deleteQuestion'])->name('quiz.questions.delete');
        Route::post('quiz/{id}/questions', [AdminQuizController::class, 'storeQuestions']);
        Route::resource('quiz', AdminQuizController::class);

        Route::delete('quiz/{quiz}/participants/{participant}', [AdminParticipantController::class, 'destroy'])->name('quiz.participants.delete');
        Route::get('quiz/{quiz}/participants', [AdminParticipantController::class, 'index'])->name('quiz.participants.index');

        Route::resource('systems', SystemController::class);
        Route::resource('certificates', CertificateController::class);

        // ECOURSES
        Route::resource('ecourses', EcoursesController::class);
        Route::resource('sections', SectionsController::class);
        Route::resource('ecourses.lessons', LessonsController::class);
        Route::resource('ecourses.subscriptions', SubscriptionsController::class);
        Route::post('ecourses/{id}/batch', AddSubscriberFromBatch::class)->name('ecourses.batch');
        Route::get('ecourses/{id}/publish', PublishEcourse::class)->name('ecourses.publish');

        // TESTIMONIALS
        Route::get('testimonials/{id}/delete', [TestimonialController::class, 'delete'])->name('testimonials.delete');
        Route::resource('testimonials', TestimonialController::class);

        // MEMBER BATCH
        Route::post('courses/{course}/batches/{batch}/updates', [MemberBatchController::class, 'updateStatuses'])->name('courses.batches.members.updates');
        Route::get('courses/{course}/batches/{batch}/members/{id}/certificate', [MemberBatchController::class, 'certificate'])->name('courses.batches.members.certificate');
        Route::get('courses/{course}/batches/{batch}/members/{id}/status/{status}', [MemberBatchController::class, 'updateStatus'])->name('courses.batches.members.status');
        Route::get('courses/{course}/batches/{batch}/members/certificates/regenerate', [MemberBatchController::class, 'regenerateCertificates'])->name('courses.batches.members.certificates.regenerate');
        Route::get('courses/{course}/batches/{batch}/members/certificates', [MemberBatchController::class, 'certificates'])->name('courses.batches.members.certificates');
        Route::get('courses/{course}/batches/{batch}/members/waitinglist', [MemberBatchController::class, 'waitinglist'])->name('courses.batches.members.waitinglist');
        Route::get('courses/{course}/batches/{batch}/members/label', [MemberBatchController::class, 'label'])->name('courses.batches.members.label');
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
        Route::get('/password', [PasswordController::class, 'index'])->name('password');
        Route::post('/password', [PasswordController::class, 'update'])->name('password.update');
        Route::get('/courses', [BatchMemberController::class, 'index'])->name('batches');
        Route::get('/courses/{member_batch_id}', [BatchMemberController::class, 'detail'])->name('batches.detail');
        Route::get('/courses/{course_id}/waitinglist', [MDashboardController::class, 'waitingList'])->name('waitinglist');
        Route::get('/batch/{id}', [MBatchController::class, 'detail'])->name('batch.detail');
        Route::post('/batch/{id}/register', [MBatchController::class, 'register'])->name('batch.register');
        Route::resource('ecourses', MemberEcoursesController::class)->only(['index','show']);
        Route::get('ecourses/{slug}/learn/{lesson?}', LessonVideo::class)->name('ecourses.lessons');
        Route::post('ecourses/{slug}/learn/{lesson}', CompleteLesson::class)->name('ecourses.lessons.complete');
    });
});

require __DIR__.'/auth.php';
