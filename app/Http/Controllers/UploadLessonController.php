<?php

namespace App\Http\Controllers;

use App\Models\Lesson;

class UploadLessonController extends Controller
{
    
    public function __invoke($collection, $id)
    {
        $lesson = Lesson::find($id);

        if($collection=='videos')
            $lesson->clearMediaCollection($collection);
        $lesson->addMediaFromRequest('file')->toMediaCollection($collection);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
