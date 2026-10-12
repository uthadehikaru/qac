<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Course;
use App\Models\Ecourse;
use App\Models\Lesson;
use App\Models\MemberBatch;
use App\Models\Order;
use App\Models\Section;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Tests\TestCase;

class BatchEcourseAccessTest extends TestCase
{
    private function createPaidBatchEcourse(array $courseAttributes = []): array
    {
        $course = Course::factory()->create(array_merge([
            'name' => 'NEW QAC 2.0',
            'level' => 2,
            'is_lite' => false,
        ], $courseAttributes));

        $batch = Batch::factory()->create([
            'course_id' => $course->id,
            'name' => 'batch 11 Pagi',
            'start_at' => Carbon::now()->subDay(),
            'end_at' => Carbon::now()->addWeeks(2),
        ]);

        System::create([
            'key' => 'ecource_access_month',
            'value' => 1,
        ]);

        $ecourse = Ecourse::factory()->published()->create([
            'title' => 'NEW QAC 2.0',
            'course_id' => $course->id,
            'is_only_active_batch' => true,
        ]);

        $section = Section::factory()->create();
        $lesson = Lesson::factory()->for($ecourse)->for($section)->create();

        return compact('course', 'batch', 'ecourse', 'lesson');
    }

    public function test_paid_batch_member_can_start_ecourse_without_subscription_order(): void
    {
        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;
        ['batch' => $batch, 'ecourse' => $ecourse, 'lesson' => $lesson] = $this->createPaidBatchEcourse();

        MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_PAID,
            'approved_at' => Carbon::now()->subDay(),
            'session' => '5.30-6.30',
        ]);

        $this->actingAs($user)
            ->get(route('member.ecourses.lessons', $ecourse->slug))
            ->assertOk()
            ->assertSee($lesson->subject)
            ->assertSessionMissing('error');
    }

    public function test_paid_batch_member_mulai_belajar_does_not_redirect_to_checkout(): void
    {
        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;
        ['batch' => $batch, 'ecourse' => $ecourse, 'lesson' => $lesson] = $this->createPaidBatchEcourse();

        $memberBatch = MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_PAID,
            'approved_at' => Carbon::now()->subDay(),
            'session' => '5.30-6.30',
        ]);

        $this->actingAs($user)
            ->get(route('member.batches.detail', $memberBatch->id))
            ->assertRedirect(route('member.ecourses.lessons', $ecourse->slug));

        $this->actingAs($user)
            ->get(route('member.ecourses.lessons', $ecourse->slug))
            ->assertOk()
            ->assertSee($lesson->subject);
    }

    public function test_member_without_paid_batch_cannot_access_batch_ecourse(): void
    {
        $user = User::factory()->create(['role' => 'member']);
        ['course' => $course, 'ecourse' => $ecourse] = $this->createPaidBatchEcourse();

        $this->actingAs($user)
            ->get(route('member.ecourses.lessons', $ecourse->slug))
            ->assertRedirect(route('kelas.qac-'.$course->level))
            ->assertSessionHas('error');
    }

    public function test_subscription_ecourse_still_requires_active_order(): void
    {
        $user = User::factory()->create(['role' => 'member']);
        $ecourse = Ecourse::factory()
            ->has(Lesson::factory(1)->for(Section::factory()))
            ->published()
            ->create([
                'is_only_active_batch' => false,
                'course_id' => null,
            ]);

        $this->actingAs($user)
            ->get(route('member.ecourses.lessons', $ecourse->slug))
            ->assertRedirect(route('checkout'))
            ->assertSessionHas('error', 'Anda belum memiliki langganan aktif');
    }

    public function test_subscription_ecourse_accessible_with_active_order(): void
    {
        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;
        Order::factory()->for($member)->create([
            'start_date' => Carbon::now()->subMonth(),
            'end_date' => Carbon::now()->addMonth(),
            'verified_at' => Carbon::now(),
        ]);
        $ecourse = Ecourse::factory()
            ->has(Lesson::factory(1)->for(Section::factory()))
            ->published()
            ->create([
                'is_only_active_batch' => false,
                'course_id' => null,
            ]);
        $lesson = $ecourse->lessons->first();

        $this->actingAs($user)
            ->get(route('member.ecourses.lessons', $ecourse->slug))
            ->assertOk()
            ->assertSee($lesson->subject);
    }
}
