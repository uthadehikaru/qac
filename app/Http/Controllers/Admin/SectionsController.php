<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\SectionsDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section;
use App\Services\SectionService;
use Illuminate\Http\Request;

class SectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SectionsDataTable $dataTable)
    {
        $data['title'] = "Sections";
        $data['button'] = '<a class="ml-3 inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.ecourses.index').'">Back</a>';
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['section'] = null;
        return view('admin.section-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SectionRequest $request, SectionService $sectionService)
    {
        $data = $request->validated();
        $data['id'] = null;
        $sectionService->updateOrCreate($data);
        return redirect()->route('admin.sections.index')->with('message','Data added');
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
    public function edit(string $id)
    {
        $data['section'] = Section::find($id);
        return view('admin.section-form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SectionRequest $request, SectionService $sectionService, string $id)
    {
        $data = $request->validated();
        $data['id'] = $id;
        $sectionService->updateOrCreate($data);
        return redirect()->route('admin.sections.index')->with('message','Data updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $section = Section::find($id);
        
        if($section){
            $section->delete();
            return response()->json(['status'=>'Deleted successfully']);
        }else
            return response()->json(['status'=>'No Section Found for id '.$id], 404);
    }
}
