<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Ecourse;
use App\Models\MemberBatch;
use Illuminate\Support\Facades\Auth;

class CourseDetailController extends Controller
{
    public function qac1Lite()
    {
        $data['course'] = Course::where('name', 'like', '%QAC 1.0 Lite%')->where('level', 0)->first();
        
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member) {
            $member = Auth::user()->member;
            $activeBatch = $this->checkUserActiveBatch($member, $data['course']->id, true);
            
            if ($activeBatch) {
                // Find ecourse based on course ID and redirect
                $ecourse = Ecourse::where('course_id', $data['course']->id)
                    ->where('is_only_active_batch', true)
                    ->first();
                
                if ($ecourse) {
                    return redirect()->route('member.ecourses.show', $ecourse->slug);
                }
            }
        }
        
        return view('kelas.qac-1-lite', $data);
    }

    public function qac1()
    {
        $data['course'] = Course::find(1);
        $data['latestBatch'] = Batch::where('course_id', $data['course']->id)->open()->first();
        
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member) {
            $member = Auth::user()->member;
            $activeBatch = $this->checkUserActiveBatch($member, $data['course']->id);
            
            if ($activeBatch) {
                // Find ecourse based on course ID and redirect
                $ecourse = Ecourse::where('course_id', $data['course']->id)
                    ->where('is_only_active_batch', true)
                    ->published()
                    ->first();
                
                if ($ecourse) {
                    return redirect()->route('member.ecourses.show', $ecourse->slug);
                }
            }
        }
        
        return view('kelas.qac-1', $data);
    }

    public function qac2()
    {
        $data['course'] = Course::find(5);
        $data['latestBatch'] = Batch::where('course_id', $data['course']->id)->open()->first();
        
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member) {
            $member = Auth::user()->member;
            $activeBatch = $this->checkUserActiveBatch($member, $data['course']->id);
            
            if ($activeBatch) {
                // Find ecourse based on course ID and redirect
                $ecourse = Ecourse::where('course_id', $data['course']->id)
                    ->where('is_only_active_batch', true)
                    ->published()
                    ->first();
                
                if ($ecourse) {
                    return redirect()->route('member.ecourses.show', $ecourse->slug);
                }
            }
        }
        
        return view('kelas.qac-2', $data);
    }

    public function qac3()
    {
        $data['course'] = Course::find(6);
        $data['latestBatch'] = Batch::where('course_id', $data['course']->id)->open()->first();
        
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member) {
            $member = Auth::user()->member;
            $activeBatch = $this->checkUserActiveBatch($member, $data['course']->id);
            
            if ($activeBatch) {
                // Find ecourse based on course ID and redirect
                $ecourse = Ecourse::where('course_id', $data['course']->id)
                    ->where('is_only_active_batch', true)
                    ->published()
                    ->first();
                
                if ($ecourse) {
                    return redirect()->route('member.ecourses.show', $ecourse->slug);
                }
            }
        }
        
        return view('kelas.qac-3', $data);
    }

    /**
     * Check if user is registered on an active batch for the given course
     */
    private function checkUserActiveBatch($member, $courseId, $isLite = false)
    {
        return MemberBatch::where('member_id', $member->id)
            ->whereHas('batch', function ($query) use ($courseId, $isLite) {
                $query->where('course_id', $courseId)
                    ->when(!$isLite, function ($query) {
                        $query->where('start_at', '<=', now())
                            ->where('end_at', '>=', now());
                    });
            })
            ->where('status', '>=', MemberBatch::STATUS_PAID)
            ->first();
    }
}

