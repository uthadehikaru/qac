<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    
    public function __invoke(Request $request, $table, $id)
    {
        $lesson = Lesson::find($id);

        $lesson->addMediaFromRequest('file')->toMediaCollection('downloads');

        return response()->json([
            'status' => 'success',
        ]);
    }
}
