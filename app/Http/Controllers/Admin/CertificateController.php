<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\CertificateDataTable;
use App\Models\Certificate;

class CertificateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CertificateDataTable $dataTable)
    {
        $data['title'] = "Data Certificates";
        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['certificate'] = null;
        return view('admin.certificate-form',$data);
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
            'name' => 'required|string|max:255',
            'config' => 'required|string',
            'template' => 'required|file',
        ]);

        $data = $request->all();
        $certificate = Certificate::create($data);

        return redirect()->route('admin.certificates.index')->with('status','Certificate created successfully');
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
        $certificate = Certificate::find($id);
        $data['value'] = $certificate->is_array?json_encode($certificate->value):$certificate->value;
        $data['certificate'] = $certificate;
        return view('admin.certificate-form',$data);
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
            'name' => 'required|string|max:255',
            'config' => 'required|string',
            'template' => 'sometimes|file',
        ]);

        $data = $request->all();
        $certificate = Certificate::find($id)->update($data);

        return redirect()->route('admin.certificates.index')->with('status','Certificate updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $certificate = Certificate::find($id);
        $certificate->delete();
        return response()->json(['status'=>'Deleted Successfully']);
    }
}
