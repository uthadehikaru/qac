<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\System;
use App\Services\EcourseService;
use App\Services\MemberService;
use App\Services\OrderService;
use App\Services\SubscriptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LessonVideo extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, EcourseService $ecourseService, SubscriptionService $subscriptionService, 
    OrderService $orderService, MemberService $memberService, string $slug, ?string $lesson_uu = null)
    {
        $member_id = Auth::user()->member?->id;
        $data['member_id'] = $member_id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        if(!$ecourse){
            return abort(404);
        }
        $activeOrder = $orderService->activeOrder();
        if(!$activeOrder && !$ecourse->is_only_active_batch){
            return redirect()->route('checkout')->with('error', 'Anda belum memiliki langganan aktif');
        }elseif($ecourse->is_only_active_batch){
            $isLite = Str::startsWith($ecourse->course->name, 'QAC 1.0 Lite');
            if($isLite){
                $batch1a = $memberService->checkMemberActiveBatch($member_id, System::value('qac_1_lite_1a'), true);
                $batch1b = $memberService->checkMemberActiveBatch($member_id, System::value('qac_1_lite_1b'), true);
                $activeBatch = $batch1a || $batch1b;
            }else{
                $activeBatch = $memberService->checkMemberActiveBatch($member_id, $ecourse->course_id, $isLite);
            }
            if(!$activeBatch){
                if($isLite){
                    return redirect()->route('kelas.qac-1-lite')->with('error', 'Anda belum memiliki langganan aktif');
                }else{
                    return redirect()->route('kelas.qac-'.$ecourse->course->level)->with('error', 'Anda belum memiliki langganan aktif');
                }
            }
        }
        $data['activeOrder'] = $activeOrder;
        $data['ecourse'] = $ecourse;
        $selectedSection = $request->section;
        $data['sections'] = $ecourseService->getEcourseSections($ecourse->id);
        if(!$selectedSection){
            $selectedSection = $data['sections']->first()?->id;
        }
        $allVideos = $subscriptionService->getVideos($ecourse->id);
        $videos = $subscriptionService->getVideos($ecourse->id, $selectedSection);
        $data['completed'] = $subscriptionService->getCompletedLessons($ecourse->id, $member_id)->pluck('lesson_id')->count();
        if ($lesson_uu) {
            $data['video'] = $subscriptionService->getLesson($lesson_uu);
        } else {
            $data['video'] = $videos->first();
        }
        if($data['video']){
            $ecourseService->addHistory($data['video']->id, $member_id);
        }
        if($data['completed'] > $allVideos->count()){
            $data['completed'] = $allVideos->count();
        }
        $data['allVideos'] = $allVideos;
        $data['videos'] = $videos;
        $data['next'] = $ecourseService->getNext($videos, $lesson_uu);

        return view('member.lesson-video', $data);
    }
} 
