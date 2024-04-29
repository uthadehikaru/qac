<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\System;
use Illuminate\Http\Request;

class SystemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Data Setting';
        $data['about_1'] = System::value('about_1');
        $data['about_2'] = System::value('about_2');
        $data['whatsapp'] = System::value('whatsapp');
        $data['whatsapp_ecourse'] = System::value('whatsapp_ecourse');
        $data['waitinglist'] = System::value('waitinglist');
        $data['popup_image'] = System::value('popup_image');
        $data['popup_active'] = System::value('popup_active');
        $data['ecource_access_month'] = System::value('ecource_access_month');
        $data['why1'] = System::where('key', 'why1')->first();
        $data['why2'] = System::where('key', 'why2')->first();

        return view('admin.setting', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['system'] = null;

        return view('admin.system-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        foreach ($request->only(['about_1', 'about_2', 'whatsapp', 'waitinglist', 'popup_image', 'popup_active', 'whatsapp_ecourse', 'ecource_access_month']) as $key => $data) {
            if ($key == 'popup_image') {
                $data = $request->file('popup_image')->store('files', 'public');
            }
            System::where('key', $key)->update(['value' => $data]);
        }

        return redirect()->route('admin.systems.index')->with('status', 'System created successfully');
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
        $data['value'] = $system->is_array ? json_encode($system->value) : $system->value;
        $data['system'] = $system;

        return view('admin.system-form', $data);
    }

    /**
     * Update the specified resource in storage.
     *
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

        return redirect()->route('admin.systems.index')->with('status', 'System updated successfully');
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

        return response()->json(['status' => 'Deleted Successfully']);
    }
}
