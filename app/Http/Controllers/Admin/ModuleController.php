<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ModuleDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\File;
use App\Models\MemberBatch;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ModuleDataTable $dataTable, $course_id)
    {
        $course = Course::find($course_id);
        $data['title'] = 'Data Modul - <a href="'.route('admin.courses.index', $course_id).'" class="pointer text-blue-500">Course '.$course->name.'</a>';
        $dataTable->setCourse($course_id);

        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($course_id)
    {
        $data['module'] = null;
        $data['memberStatus'] = MemberBatch::statuses;
        $data['course'] = Course::find($course_id);

        return view('admin.module-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $course_id)
    {
        $request->validate([
            'module_no' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'member_status' => 'required|numeric|min:0',
            'filename' => 'required',
        ]);

        $course = Course::find($course_id);

        $module = Module::create([
            'module_no' => $request->module_no,
            'name' => $request->name,
            'member_status' => $request->member_status,
            'course_id' => $course_id,
        ]);
        if ($request->hasFile('filename')) {
            $file = File::create([
                'name' => $course->name.' module '.$request->module_no.' '.$request->name,
                'filename' => $request->file('filename')->getClientOriginalName(),
                'tablename' => 'modules',
                'record_id' => $module->id,
                'type' => $request->file('filename')->getClientOriginalExtension(),
                'size' => $request->file('filename')->getSize(),
            ]);
        }

        return redirect()->route('admin.courses.modules.index', $course_id)->with('status', 'Module created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($course_id, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id, $id)
    {
        $data['module'] = Module::find($id);
        $data['memberStatus'] = MemberBatch::statuses;
        $data['course'] = Course::find($course_id);

        return view('admin.module-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_id, $id)
    {
        $request->validate([
            'module_no' => 'required|numeric|min:0',
            'name' => 'required|string|max:255',
            'member_status' => 'required|numeric|min:0',
            'filename' => 'required',
        ]);

        $module = Module::find($id);
        $course = Course::find($course_id);
        $module->update([
            'module_no' => $request->module_no,
            'name' => $request->name,
            'member_status' => $request->member_status,
        ]);
        if ($request->hasFile('filename')) {
            $file = $module->file;
            if ($file) {
                $file->deleteFile($file->filename);
                $file->update([
                    'name' => $course->name.' module '.$request->module_no.' '.$request->name,
                    'type' => $request->file('filename')->getClientOriginalExtension(),
                    'size' => $request->file('filename')->getSize(),
                ]);
            } else {
                $file = File::create([
                    'name' => $course->name.' module '.$request->module_no.' '.$request->name,
                    'filename' => $request->file('filename')->getClientOriginalName(),
                    'tablename' => 'modules',
                    'record_id' => $module->id,
                    'type' => $request->file('filename')->getClientOriginalExtension(),
                    'size' => $request->file('filename')->getSize(),
                ]);
            }
        }

        return redirect()->route('admin.courses.modules.index', $course_id)->with('status', 'Module updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_id, $id)
    {
        $module = Module::find($id);

        if ($module) {
            if ($module->file) {
                $module->file->delete();
            }
            $module->delete();

            return response()->json(['status' => 'Deleted successfully']);
        } else {
            return response()->json(['status' => 'No Module Found for id '.$id], 404);
        }
    }
}
