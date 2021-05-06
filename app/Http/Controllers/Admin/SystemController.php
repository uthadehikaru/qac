<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SystemDataTable;
use App\Models\System;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SystemDataTable $dataTable)
    {
        $data['title'] = "Data Setting";
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['system'] = null;
        return view('admin.system-form',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'is_array' => 'required|boolean',
        ]);

        $data = $request->all();
        $system = System::create($data);

        return redirect()->route('admin.systems.index')->with('status','System created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $system = System::find($id);
        $data['value'] = $system->is_array?json_encode($system->value):$system->value;
        $data['system'] = $system;
        return view('admin.system-form',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'key' => 'required|string|max:255',
            'value' => 'required|string',
            'is_array' => 'required|boolean',
        ]);

        $data = $request->all();
        $system = System::find($id)->update($data);

        return redirect()->route('admin.systems.index')->with('status','System updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $system = System::find($id);
        $system->delete();
        return response()->json(['status'=>'Deleted Successfully']);
    }
}
