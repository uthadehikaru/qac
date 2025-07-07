<?php

namespace App\Services;

use App\Models\Member;
use App\Models\MemberBatch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

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

    

    /**
     * Check if user is registered on an active batch for the given course
     */
    public function checkMemberActiveBatch($memberId, $courseId, $isLite = false)
    {
        $memberBatch = MemberBatch::where('member_id', $memberId)
            ->whereHas('batch', function ($query) use ($courseId, $isLite) {
                $query->where('course_id', $courseId)
                ->when(!$isLite, function ($query) {
                    $query->where('start_at', '<=', now())
                        ->where('end_at', '>=', now());
                });
            })
            ->where('status', '>=', MemberBatch::STATUS_PAID)
            ->first();
        if($isLite && $memberBatch){
            $approved_at = $memberBatch->approved_at;
            $end_course = Carbon::parse($approved_at)->addDays(30);
            if($end_course->isPast()){
                return null;
            }
        }
        return $memberBatch;
    }

}