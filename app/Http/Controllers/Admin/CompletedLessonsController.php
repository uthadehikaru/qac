<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CompletedLessonsDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CompletedLessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CompletedLessonsDataTable $dataTable, $ecourse_id)
    {
        $lesson_id = $request->get('lesson');
        $data['title'] = 'Completed Lessons';
        $data['buttons'][] = [
            'name' => 'Back',
            'href' => route('admin.ecourses.index'),
        ];
        $dataTable->setEcourse($ecourse_id);
        $dataTable->setLesson($lesson_id);

        return $dataTable->render('admin.datatable', $data);
    }
}
