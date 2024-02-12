<?php

use App\Models\Batch;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::post('/regencies/{province_id}', function (Request $request, $province_id) {
    $data = DB::table('regencies')->where('province_id',$province_id)->orderBy('name')->get()->toJson(JSON_PRETTY_PRINT);
    return response($data, 200);
});

Route::post('/districts/{regency_id}', function (Request $request, $regency_id) {
    $data = DB::table('districts')->where('regency_id',$regency_id)->orderBy('name')->get()->toJson(JSON_PRETTY_PRINT);
    return response($data, 200);
});

Route::post('/villages/{district_id}', function (Request $request, $district_id) {
    $data = DB::table('villages')->where('district_id',$district_id)->orderBy('name')->get()->toJson(JSON_PRETTY_PRINT);
    return response($data, 200);
});

Route::get('/batches/{course_id}', function (Request $request, $course_id) {
    $data = Batch::where('course_id',$course_id)->pluck('name','id');
    return response($data, 200);
});

Route::get('/members/{batch_id}', function (Request $request, $batch_id) {
    $data = Member::whereRelation('batches','batches.id',$batch_id)->pluck('full_name','id');
    return response($data, 200);
});
