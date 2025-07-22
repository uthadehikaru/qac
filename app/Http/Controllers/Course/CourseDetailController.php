<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Ecourse;
use App\Models\System;
use App\Services\MemberService;
use Illuminate\Support\Facades\Auth;

class CourseDetailController extends Controller
{
    public function qac1Lite(MemberService $memberService)
    {
        $data['course'] = Course::find(System::value('qac_1_lite_1a'));
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member && $data['course']) {
            $member = Auth::user()->member;
            $activeBatch = $memberService->checkMemberActiveBatch($member->id, $data['course']->id, true);
            
            if ($activeBatch) {
                // Find ecourse based on course ID and redirect
                $ecourse = Ecourse::where('course_id', $data['course']->id)
                    ->where('is_only_active_batch', true)
                    ->first();
                if ($ecourse) {
                    return redirect()->route('member.ecourses.lessons', $ecourse->slug);
                }
            }
        }
        
        return view('kelas.qac-1-lite', $data);
    }

    public function qac1(MemberService $memberService)
    {
        $data['course'] = Course::find(System::value('qac_1'));
        $data['latestBatch'] = Batch::where('course_id', $data['course']?->id)->open()->first();
        
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member && $data['course']) {
            $member = Auth::user()->member;
            $activeBatch = $memberService->checkMemberActiveBatch($member->id, $data['course']->id);
            
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

    public function qac2(MemberService $memberService)
    {
        $data['course'] = Course::find(System::value('qac_2'));
        $data['latestBatch'] = Batch::where('course_id', $data['course']?->id)->open()->first();
        
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member && $data['course']) {
            $member = Auth::user()->member;
            $activeBatch = $memberService->checkMemberActiveBatch($member->id, $data['course']->id);
            
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

    public function qac3(MemberService $memberService)
    {
        $data['course'] = Course::find(System::value('qac_3'));
        $data['latestBatch'] = Batch::where('course_id', $data['course']?->id)->open()->first();
        
        // Check if user is logged in and registered on active batch
        if (Auth::check() && Auth::user()->member && $data['course']) {
            $member = Auth::user()->member;
            $activeBatch = $memberService->checkMemberActiveBatch($member->id, $data['course']->id);
            
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
}

