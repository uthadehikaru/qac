<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Course;
use App\Models\Batch;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/courses', function (Request $request) {
    $courses = Course::pluck('name','id')->toJson(JSON_PRETTY_PRINT);
    return response($courses, 200);
});

Route::get('/batches/{course_id}', function (Request $request, $course_id) {
    $batches = Batch::where('course_id',$course_id)->pluck('name','id')->toJson(JSON_PRETTY_PRINT);
    return response($batches, 200);
});

Route::get('/members/{batch_id}', function (Request $request, $batch_id) {
    $members = Batch::find($batch_id)->members()->pluck('full_name','member_batch.id')->toJson(JSON_PRETTY_PRINT);
    return response($members, 200);
});
