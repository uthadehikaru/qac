<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LessonsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Lesson;
use App\Services\EcourseService;

class LessonsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LessonsDataTable $dataTable)
    {
        $data['title'] = 'Online Courses';

        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(EcourseService $ecourseService, $ecourse_id)
    {
        $data['lesson'] = null;
        $data['ecourse'] = $ecourseService->find($ecourse_id);
        $data['sections'] = $ecourseService->getSections();

        return view('admin.lesson-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EcourseService $ecourseService, LessonRequest $request, $ecourse_id)
    {
        $data = $request->validated();
        $data['id'] = null;
        $data['ecourse_id'] = $ecourse_id;
        $lesson = $ecourseService->updateOrCreateLesson($data);

        return redirect()->route('admin.ecourses.lessons.edit', [$ecourse_id, $lesson->id])->with('message', 'Lesson Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EcourseService $ecourseService, string $ecourse_id, string $id)
    {
        $data['lesson'] = $ecourseService->getLesson($id);
        $data['ecourse'] = $ecourseService->find($ecourse_id);
        $data['sections'] = $ecourseService->getSections();

        return view('admin.lesson-form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EcourseService $ecourseService, LessonRequest $request, string $ecourse_id, string $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $data['ecourse_id'] = $ecourse_id;
        $ecourseService->updateOrCreateLesson($data);

        return redirect()->route('admin.ecourses.show', $ecourse_id)->with('message', 'Lesson Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ecourse_id, string $id)
    {
        $lesson = Lesson::find($id);

        if ($lesson) {
            $lesson->delete();

            return response()->json(['status' => 'Deleted successfully']);
        } else {
            return response()->json(['status' => 'No Lesson Found for id '.$id], 404);
        }
    }
}
