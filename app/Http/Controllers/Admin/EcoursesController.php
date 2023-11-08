<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EcoursesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\EcourseRequest;
use App\Services\EcourseService;
use Illuminate\Http\Request;

class EcoursesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EcoursesDataTable $dataTable)
    {
        $data['title'] = "Online Courses";
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['ecourse'] = null;
        return view('admin.ecourse-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EcourseRequest $request, EcourseService $ecourseService)
    {
        $data = $request->validated();
        $ecourse = $ecourseService->updateOrCreate($data);
        return redirect()->route('admin.ecourses.show', $ecourse->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(EcourseService $ecourseService, string $id)
    {
        $data['ecourse'] = $ecourseService->find($id);
        return view('admin.ecourse-detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
