<?php

namespace App\Services;

use App\Models\Ecourse;
use App\Models\Lesson;

class SubscriptionService {

    public function getEcourse($slug, $member_id)
    {
        return Ecourse::with('lessons')
        ->where('slug',$slug)
        ->whereRelation('subscribers','member_id',$member_id)
        ->first();
    }

    public function getSections($ecourse_id)
    {
        return Lesson::where('ecourse_id',$ecourse_id)
        ->with('section')
        ->select('section_id')
        ->groupBy('section_id')
        ->get();
    }
}