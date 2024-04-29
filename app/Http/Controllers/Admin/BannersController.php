<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BannerDataTable $dataTable)
    {
        $data['title'] = 'Banners';

        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['banner'] = null;

        return view('admin.banner-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|string|max:255',
            'image' => 'required|file',
            'is_active' => 'required',
        ]);

        $data = $request->all();
        Banner::create($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner created successfully');
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
        $data['banner'] = Banner::find($id);

        return view('admin.banner-form', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'url' => 'required|string|max:255',
            'image' => 'nullable|file',
            'is_active' => 'required',
        ]);

        $banner = Banner::findOrFail($id);

        $data = $request->all();
        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        $banner->delete();

        return response()->json(['status' => 'Deleted Successfully']);
    }
}
