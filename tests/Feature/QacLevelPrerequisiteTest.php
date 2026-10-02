<?php

namespace Tests\Feature;

use App\Models\Batch;
use App\Models\Course;
use App\Models\MemberBatch;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class QacLevelPrerequisiteTest extends TestCase
{
    private function openBatch(array $courseAttributes = [], array $batchAttributes = []): Batch
    {
        $course = Course::factory()->create($courseAttributes);
        $now = Carbon::now();

        return Batch::factory()->create(array_merge([
            'course_id' => $course->id,
            'registration_start_at' => $now->copy()->subDay(),
            'registration_end_at' => $now->copy()->addWeek(),
            'start_at' => $now->copy()->addWeeks(2),
            'end_at' => $now->copy()->addWeeks(3),
        ], $batchAttributes));
    }

    public function test_member_level_uses_highest_graduated_course_level()
    {
        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;

        $qac1 = Course::factory()->create(['name' => 'QAC 1.0', 'level' => 1]);
        $lite1a = Course::factory()->create(['name' => 'QAC 1.0 Lite 1a', 'level' => 0, 'is_lite' => true]);

        $batchQac1 = Batch::factory()->create(['course_id' => $qac1->id, 'name' => '16 pagi']);
        $batchLite1a = Batch::factory()->create(['course_id' => $lite1a->id, 'name' => 'online bundling']);

        // Older graduation at level 1, then later graduation at level 0 (Lite 1a)
        $member->batches()->attach($batchQac1->id, ['status' => MemberBatch::STATUS_GRADUATED]);
        $member->batches()->attach($batchLite1a->id, ['status' => MemberBatch::STATUS_GRADUATED]);

        $this->assertEquals(1, $member->level());
    }

    public function test_qac1_graduate_can_register_qac2_even_after_later_lite_graduation()
    {
        Notification::fake();

        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;

        $qac1 = Course::factory()->create(['name' => 'QAC 1.0', 'level' => 1]);
        $lite1a = Course::factory()->create(['name' => 'QAC 1.0 Lite 1a', 'level' => 0, 'is_lite' => true]);
        $batchQac1 = Batch::factory()->create(['course_id' => $qac1->id, 'name' => '16 pagi']);
        $batchLite1a = Batch::factory()->create(['course_id' => $lite1a->id, 'name' => 'online bundling']);

        $member->batches()->attach($batchQac1->id, ['status' => MemberBatch::STATUS_GRADUATED]);
        $member->batches()->attach($batchLite1a->id, ['status' => MemberBatch::STATUS_GRADUATED]);

        // Lite 1b paid but not graduated — should not affect max level
        $lite1b = Course::factory()->create(['name' => 'QAC 1.0 Lite 1b', 'level' => 1, 'is_lite' => true]);
        $batchLite1b = Batch::factory()->create(['course_id' => $lite1b->id, 'name' => 'online bundling']);
        $member->batches()->attach($batchLite1b->id, ['status' => MemberBatch::STATUS_PAID]);

        $qac2Batch = $this->openBatch(['name' => 'NEW QAC 2.0', 'level' => 2], ['name' => '11']);

        $this->assertEquals(1, $member->fresh()->level());
        $this->assertEquals(2, $qac2Batch->course->level);

        $response = $this->actingAs($user)
            ->from(route('member.batch.detail', $qac2Batch->id))
            ->post(route('member.batch.register', $qac2Batch->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionMissing('error');

        $this->assertDatabaseHas('member_batch', [
            'member_id' => $member->id,
            'batch_id' => $qac2Batch->id,
        ]);
    }

    public function test_member_without_level1_cannot_register_qac2()
    {
        Notification::fake();

        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;

        $lite1a = Course::factory()->create(['name' => 'QAC 1.0 Lite 1a', 'level' => 0, 'is_lite' => true]);
        $batchLite1a = Batch::factory()->create(['course_id' => $lite1a->id, 'name' => 'online']);
        $member->batches()->attach($batchLite1a->id, ['status' => MemberBatch::STATUS_GRADUATED]);

        $qac2Batch = $this->openBatch(['name' => 'NEW QAC 2.0', 'level' => 2], ['name' => '11']);

        $response = $this->actingAs($user)
            ->from(route('member.batch.detail', $qac2Batch->id))
            ->post(route('member.batch.register', $qac2Batch->id));

        $response->assertRedirect(route('member.batch.detail', $qac2Batch->id));
        $response->assertSessionHas('error', 'Maaf, Anda belum menyelesaikan level sebelumnya');

        $this->assertDatabaseMissing('member_batch', [
            'member_id' => $member->id,
            'batch_id' => $qac2Batch->id,
        ]);
    }

    public function test_qac1_graduate_can_register_qac2_via_course_register()
    {
        Notification::fake();

        $user = User::factory()->create(['role' => 'member']);
        $member = $user->member;

        $qac1 = Course::factory()->create(['name' => 'QAC 1.0', 'level' => 1]);
        $lite1a = Course::factory()->create(['name' => 'QAC 1.0 Lite 1a', 'level' => 0, 'is_lite' => true]);
        $batchQac1 = Batch::factory()->create(['course_id' => $qac1->id]);
        $batchLite1a = Batch::factory()->create(['course_id' => $lite1a->id]);

        $member->batches()->attach($batchQac1->id, ['status' => MemberBatch::STATUS_GRADUATED]);
        $member->batches()->attach($batchLite1a->id, ['status' => MemberBatch::STATUS_GRADUATED]);

        $qac2Batch = $this->openBatch(['name' => 'NEW QAC 2.0', 'level' => 2], ['name' => '11']);

        $response = $this->actingAs($user)
            ->from(route('kelas.register', ['course_id' => $qac2Batch->course_id, 'batch_id' => $qac2Batch->id]))
            ->post(route('kelas.register.submit', ['course_id' => $qac2Batch->course_id]), [
                'full_name' => $member->full_name,
                'batch_id' => $qac2Batch->id,
                'phone' => '6281212345678',
                'job' => 'karyawan',
                'education' => 'S1',
                'lite' => 0,
                'is_registered' => 1,
                'term_condition' => 1,
            ]);

        $response->assertRedirect(route('member.orders.index'));
        $response->assertSessionHas('success');
        $response->assertSessionMissing('error');

        $this->assertDatabaseHas('member_batch', [
            'member_id' => $member->id,
            'batch_id' => $qac2Batch->id,
        ]);
    }
}
