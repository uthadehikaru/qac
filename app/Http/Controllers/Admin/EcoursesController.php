<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\EcoursesDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\EcourseRequest;
use App\Models\Ecourse;
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
        $data['button'] = '<a class="ml-3 inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.sections.index').'">Sections</a>';
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
        return redirect()->route('admin.ecourses.show', $ecourse->id)
        ->with('message','data created');
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
        $data['ecourse'] = Ecourse::find($id);
        return view('admin.ecourse-form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EcourseRequest $request, EcourseService $ecourseService, string $id)
    {
        $data = $request->validated();
        $ecourse = $ecourseService->updateOrCreate($data, $id);
        return redirect()->route('admin.ecourses.show', $ecourse->id)
        ->with('message','data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
