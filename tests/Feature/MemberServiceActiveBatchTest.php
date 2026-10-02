<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Course;
use App\Models\MemberBatch;
use App\Models\System;
use App\Models\User;
use App\Services\MemberService;
use Carbon\Carbon;
use Tests\TestCase;

class MemberServiceActiveBatchTest extends TestCase
{
    public function test_returns_null_when_member_has_no_paid_batch_for_course(): void
    {
        $user = User::factory()->create();
        $member = $user->member;
        $course = Course::factory()->create();

        $result = (new MemberService)->checkMemberActiveBatch($member->id, $course->id);

        $this->assertNull($result);
    }

    public function test_returns_member_batch_when_non_lite_access_is_still_valid(): void
    {
        $user = User::factory()->create();
        $member = $user->member;
        $course = Course::factory()->create();
        $batch = Batch::factory()->create([
            'course_id' => $course->id,
            'end_at' => Carbon::now()->subDays(10),
        ]);
        System::create([
            'key' => 'ecource_access_month',
            'value' => 2,
        ]);

        MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_PAID,
            'approved_at' => Carbon::now()->subDays(5),
        ]);

        $result = (new MemberService)->checkMemberActiveBatch($member->id, $course->id);

        $this->assertNotNull($result);
        $this->assertEquals($member->id, $result->member_id);
        $this->assertEquals($batch->id, $result->batch_id);
    }

    public function test_returns_null_when_non_lite_access_has_expired(): void
    {
        $user = User::factory()->create();
        $member = $user->member;
        $course = Course::factory()->create();
        Batch::factory()->create([
            'course_id' => $course->id,
            'end_at' => Carbon::now()->subMonths(3),
        ]);
        System::create([
            'key' => 'ecource_access_month',
            'value' => 1,
        ]);

        MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => Batch::where('course_id', $course->id)->first()->id,
            'status' => MemberBatch::STATUS_PAID,
            'approved_at' => Carbon::now()->subMonths(3),
        ]);

        $result = (new MemberService)->checkMemberActiveBatch($member->id, $course->id);

        $this->assertNull($result);
    }

    public function test_member_without_active_batch_can_open_qac2_page(): void
    {
        $course = Course::factory()->create();
        System::create([
            'key' => 'qac_2',
            'value' => (string) $course->id,
        ]);

        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('kelas.qac-2'))
            ->assertOk()
            ->assertSee('QAC 2.0');
    }
}
