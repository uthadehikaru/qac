<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\TestimonialDataTable;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\MemberBatch;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TestimonialDataTable $dataTable)
    {
        $data['title'] = 'Data Testimonial';

        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['testimonial'] = null;
        $data['courses'] = Course::orderBy('level')->get();

        return view('admin.testimonial-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required',
            'testimonial' => 'required',
        ]);

        $data = $request->all();
        $batch = MemberBatch::where('member_id', $request->member_id)
            ->where('batch_id', $request->batch_id)
            ->update(['testimonial' => $request->testimonial]);

        return redirect()->route('admin.testimonials.index')->with('status', 'Testimonial created successfully');
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
        $testimonial = System::find($id);
        $data['value'] = $testimonial->is_array ? json_encode($testimonial->value) : $testimonial->value;
        $data['testimonial'] = $testimonial;

        return view('admin.testimonial-form', $data);
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
        $testimonial = System::find($id)->update($data);

        return redirect()->route('admin.testimonials.index')->with('status', 'System updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $batch = MemberBatch::find($id);
        $batch->testimonial = null;
        $batch->save();

        return redirect()->route('admin.testimonials.index')->with('status', 'Deleted successfully');
    }
}
