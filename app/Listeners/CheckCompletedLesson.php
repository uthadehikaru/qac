<?php

namespace App\Listeners;

use App\Events\CompletedLessonUpdated;
use App\Models\Certificate;
use App\Models\File;
use App\Models\MemberBatch;
use App\Notifications\CertificateCreated;
use App\Services\MemberService;
use Carbon\Carbon;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CheckCompletedLesson
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(CompletedLessonUpdated $event): void
    {
        $completedLesson = $event->completedLesson;
        
        // Safety checks first
        if (!$completedLesson) {
            Log::warning("CompletedLesson is null");
            return;
        }
        
        $lesson = $completedLesson->lesson;
        $member = $completedLesson->member;
        
        if (!$lesson || !$member) {
            Log::warning("Missing required data for completed lesson check", [
                'completed_lesson_id' => $completedLesson->id,
                'lesson_id' => $completedLesson->lesson_id,
                'member_id' => $completedLesson->member_id
            ]);
            return;
        }
        
        $ecourse = $lesson->ecourse;
        
        if (!$ecourse) {
            Log::warning("Ecourse not found for lesson", [
                'lesson_id' => $lesson->id,
                'ecourse_id' => $lesson->ecourse_id
            ]);
            return;
        }
        
        // Get all lessons for this ecourse
        $totalLessons = $ecourse->lessons()->count();
        
        // Get completed lessons for this member and ecourse
        $completedLessons = $member->completedLessons()
            ->whereHas('lesson', function ($query) use ($ecourse) {
                $query->where('ecourse_id', $ecourse->id);
            })
            ->count();
        
        // Check if all lessons are completed
        if ($completedLessons >= $totalLessons && $totalLessons > 0) {
            Log::info("Member {$member->id} has completed all lessons for ecourse {$ecourse->id} ({$completedLessons}/{$totalLessons})");
            
            // Find the member's batch for this course
            $memberBatch = MemberBatch::where('member_id', $member->id)
                ->whereHas('batch', function ($query) use ($ecourse) {
                    $query->where('course_id', $ecourse->course_id);
                })
                ->where('status', '>=', MemberBatch::STATUS_PAID)
                ->where('status', '<', MemberBatch::STATUS_GRADUATED)
                ->first();
            
            if ($memberBatch) {
                // Update member batch status to graduated
                $memberBatch->update([
                    'status' => MemberBatch::STATUS_GRADUATED
                ]);
                
                Log::info("Updated member batch {$memberBatch->id} to graduated status for member {$member->id}");
                
                // Generate certificate if batch has certificate template
                if ($memberBatch->batch->certificate_id) {
                    (new MemberService)->generateCertificate($memberBatch->batch->certificate, $memberBatch);
                } else {
                    Log::info("No certificate template found for batch {$memberBatch->batch_id}");
                }
            } else {
                Log::warning("No active member batch found for member {$member->id} and course {$ecourse->course_id}");
            }
        } else {
            Log::debug("Member {$member->id} has completed {$completedLessons}/{$totalLessons} lessons for ecourse {$ecourse->id}");
        }
    }
}
