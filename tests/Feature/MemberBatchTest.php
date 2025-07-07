<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Course;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberBatchTest extends TestCase
{
    use RefreshDatabase;

    public function test_approved_at_is_set_when_status_changes_to_paid()
    {
        // Create test data
        $user = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $user->id]);
        $course = Course::factory()->create();
        $batch = Batch::factory()->create(['course_id' => $course->id]);
        
        // Create a member batch with initial status
        $memberBatch = MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_REGISTERED,
        ]);

        // Verify approved_at is null initially
        $this->assertNull($memberBatch->approved_at);

        // Update status to PAID
        $memberBatch->update(['status' => MemberBatch::STATUS_PAID]);

        // Verify approved_at is now set
        $this->assertNotNull($memberBatch->fresh()->approved_at);
        $this->assertEquals(now()->format('Y-m-d H:i:s'), $memberBatch->fresh()->approved_at->format('Y-m-d H:i:s'));
    }

    public function test_approved_at_is_not_set_for_other_status_changes()
    {
        // Create test data
        $user = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $user->id]);
        $course = Course::factory()->create();
        $batch = Batch::factory()->create(['course_id' => $course->id]);
        
        // Create a member batch with initial status
        $memberBatch = MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_REGISTERED,
        ]);

        // Update status to SHIPPED (not PAID)
        $memberBatch->update(['status' => MemberBatch::STATUS_SHIPPED]);

        // Verify approved_at is still null
        $this->assertNull($memberBatch->fresh()->approved_at);
    }

    public function test_approved_at_is_only_set_when_status_changes_to_paid()
    {
        // Create test data
        $user = User::factory()->create();
        $member = Member::factory()->create(['user_id' => $user->id]);
        $course = Course::factory()->create();
        $batch = Batch::factory()->create(['course_id' => $course->id]);
        
        // Create a member batch with PAID status initially
        $memberBatch = MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_PAID,
        ]);

        // Verify approved_at is set initially
        $this->assertNotNull($memberBatch->approved_at);
        $initialApprovedAt = $memberBatch->approved_at;

        // Update other fields but not status
        $memberBatch->update(['note' => 'Test note']);

        // Verify approved_at remains the same
        $this->assertEquals($initialApprovedAt, $memberBatch->fresh()->approved_at);
    }
} 