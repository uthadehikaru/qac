<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberBatch;
use Illuminate\Support\Facades\Cache;

class MemberService
{
    public function isAlumni($member_id)
    {
        return Cache::remember('member_is_alumni_'.$member_id, 3600, function () use ($member_id) {
            $member = Member::with(['batches', 'courses'])->find($member_id);
            return $member->batches->contains(function ($memberBatch, $key) {
                return $memberBatch->pivot->status >= MemberBatch::STATUS_PAID 
                    && $memberBatch->course->level >= 1;
            });
        });
    }

}