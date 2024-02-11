<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\BannerDataTable;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function destroy($id)
    {
        Media::find($id)->delete();
        return back()->with('message','deleted');
    }

}