<?php

namespace App\Http\Controllers;

use App\Models\System;

class UploadMediaController extends Controller
{
    public function __invoke($name, $id, $collection = 'files')
    {
        $model = null;
        if ($name == 'system') {
            $model = System::find($id);
        }

        if (! $model) {
            return response()->json(['status' => 'failed'], 404);
        }

        $model->addMediaFromRequest('file')->toMediaCollection($collection);

        return response()->json([
            'status' => 'success',
        ]);
    }
}
