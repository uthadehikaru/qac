<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Services\EcourseService;
use App\Services\MemberService;
use App\Services\OrderService;
use App\Services\SubscriptionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LessonVideo extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(EcourseService $ecourseService, SubscriptionService $subscriptionService, 
    OrderService $orderService, MemberService $memberService, string $slug, ?string $lesson_uu = null)
    {
        $member_id = Auth::user()->member?->id;
        $data['member_id'] = $member_id;
        $ecourse = $subscriptionService->getEcourse($slug, $member_id);
        $activeOrder = $orderService->activeOrder();
        if(!$activeOrder && !$ecourse->is_only_active_batch){
            return redirect()->route('checkout')->with('error', 'Anda belum memiliki langganan aktif');
        }else{
            $isLite = Str::startsWith($ecourse->course->name, 'QAC 1.0 Lite');
            $activeBatch = $memberService->checkMemberActiveBatch($member_id, $ecourse->course_id, $isLite);
            if(!$activeBatch){
                if($isLite){
                    return redirect()->route('kelas.qac-1-lite')->with('error', 'Anda belum memiliki langganan aktif');
                }else{
                    return redirect()->route('kelas.qac-'.$ecourse->course->level)->with('error', 'Anda belum memiliki langganan aktif');
                }
            }
        }
        $data['ecourse'] = $ecourse;
        $data['sections'] = $ecourseService->getEcourseSections($ecourse->id);
        $videos = $subscriptionService->getVideos($ecourse->id);
        if ($lesson_uu) {
            $data['video'] = $subscriptionService->getLesson($lesson_uu);
        } else {
            $data['video'] = $videos->first();
        }
        if(!$data['video']){
            return redirect()->route('member.ecourses.show', $slug);
        }
        $ecourseService->addHistory($data['video']->id, $member_id);
        $data['videos'] = $videos;
        $data['next'] = $ecourseService->getNext($videos, $lesson_uu);

        return view('member.lesson-video', $data);
    }
}
