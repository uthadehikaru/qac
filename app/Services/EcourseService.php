<?php

namespace App\Services;

use App\Models\Ecourse;

class EcourseService {

    public function latestEcourses($limit=8)
    {
        return Ecourse::published()->latest()->take($limit)->get();
    }

    public function publishedEcourses()
    {
        return Ecourse::published()->latest()->paginate(6);
    }
}