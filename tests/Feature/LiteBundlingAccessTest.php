<?php

namespace Tests\Feature;

use App\Helpers\AppHelper;
use App\Listeners\UpdateLiteBatch;
use App\Events\MemberBatchUpdated;
use App\Models\Batch;
use App\Models\Course;
use App\Models\MemberBatch;
use App\Models\Order;
use App\Models\System;
use App\Models\User;
use App\Services\MemberService;
use Carbon\Carbon;
use Tests\TestCase;

class LiteBundlingAccessTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_qac_lite_bundling_active_period_is_twice_the_configured_months(): void
    {
        System::create([
            'key' => 'ecource_access_month',
            'value' => '3',
            'is_array' => false,
        ]);

        $user = User::factory()->create();
        $member = $user->member;
        $lite1a = Course::factory()->create([
            'name' => 'QAC 1.0 Lite 1a',
            'is_lite' => true,
            'level' => 0,
        ]);
        $lite1b = Course::factory()->create([
            'name' => 'QAC 1.0 Lite 1b',
            'is_lite' => true,
            'level' => 1,
        ]);
        $batch1a = Batch::factory()->create([
            'course_id' => $lite1a->id,
            'name' => 'online',
            'sessions' => '',
        ]);
        $batch1b = Batch::factory()->create([
            'course_id' => $lite1b->id,
            'name' => 'online',
            'sessions' => '',
        ]);

        $member->batches()->attach($batch1a->id, ['session' => 'bundling']);
        $member->batches()->attach($batch1b->id, ['session' => 'bundling']);

        $memberBatch1a = MemberBatch::where('member_id', $member->id)
            ->where('batch_id', $batch1a->id)
            ->first();
        $memberBatch1b = MemberBatch::where('member_id', $member->id)
            ->where('batch_id', $batch1b->id)
            ->first();

        $approvedAt = Carbon::parse('2026-10-27 09:00:00');
        Carbon::setTestNow($approvedAt);

        $memberBatch1a->status = MemberBatch::STATUS_PAID;
        $memberBatch1a->approved_at = $approvedAt;

        (new UpdateLiteBatch)->handle(new MemberBatchUpdated($memberBatch1a));

        $order = Order::where('member_id', $member->id)->first();
        $this->assertNotNull($order);
        $this->assertSame(6, (int) $order->months);
        $this->assertSame('2027-04-27', $order->end_date->format('Y-m-d'));

        $memberBatch1a->save();
        $memberBatch1b->refresh();
        $this->assertSame(MemberBatch::STATUS_PAID, (int) $memberBatch1b->status);
        $this->assertSame('bundling', $memberBatch1b->session);

        $duration = AppHelper::liteduration($memberBatch1a->id);
        $this->assertSame('27 Oct 2026 s/d 27 Apr 2027', $duration);

        $this->actingAs($user)
            ->get(route('member.dashboard'))
            ->assertOk()
            ->assertSee('27 Oct 2026 s/d 27 Apr 2027');

        $this->actingAs($user)
            ->get(route('member.orders.index'))
            ->assertOk()
            ->assertSee('Langganan Acara Alumni 6 bulan');

        Carbon::setTestNow($approvedAt->copy()->addMonths(6)->subDay());
        $this->assertNotNull(
            (new MemberService)->checkMemberActiveBatch($member->id, $lite1a->id, true)
        );

        Carbon::setTestNow($approvedAt->copy()->addMonths(6)->addDay());
        $this->assertNull(
            (new MemberService)->checkMemberActiveBatch($member->id, $lite1a->id, true)
        );

        Carbon::setTestNow();
    }

    public function test_admin_confirmation_keeps_bundling_session_and_grants_six_months(): void
    {
        System::create([
            'key' => 'ecource_access_month',
            'value' => '3',
            'is_array' => false,
        ]);

        $admin = User::factory()->create(['role' => 'admin']);
        $memberUser = User::factory()->create();
        $member = $memberUser->member;
        $course = Course::factory()->create([
            'name' => 'QAC 1.0 Lite 1a',
            'is_lite' => true,
            'level' => 0,
        ]);
        $batch = Batch::factory()->create([
            'course_id' => $course->id,
            'name' => 'online',
            'sessions' => '',
        ]);
        $memberBatch = MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_REGISTERED,
            'session' => 'bundling',
        ]);

        $approvedAt = Carbon::parse('2026-10-27 09:00:00');
        Carbon::setTestNow($approvedAt);

        $this->actingAs($admin)
            ->get(route('admin.courses.batches.members.edit', [$course->id, $batch->id, $memberBatch->id]))
            ->assertOk()
            ->assertSee('value="bundling" selected', false);

        $this->actingAs($admin)
            ->post(route('admin.courses.batches.members.update', [$course->id, $batch->id, $memberBatch->id]), [
                'session' => '',
                'status' => MemberBatch::STATUS_PAID,
                'note' => '',
                'reseat' => 0,
            ])
            ->assertRedirect();

        $memberBatch->refresh();
        $this->assertSame('bundling', $memberBatch->session);
        $this->assertSame(MemberBatch::STATUS_PAID, (int) $memberBatch->status);

        $order = Order::where('member_id', $member->id)->first();
        $this->assertNotNull($order);
        $this->assertSame(6, (int) $order->months);
        $this->assertSame('2027-04-27', $order->end_date->format('Y-m-d'));
        $this->assertSame('27 Oct 2026 s/d 27 Apr 2027', AppHelper::liteduration($memberBatch->id));

        Carbon::setTestNow();
    }

    public function test_single_lite_package_uses_configured_access_months_without_doubling(): void
    {
        System::create([
            'key' => 'ecource_access_month',
            'value' => '3',
            'is_array' => false,
        ]);

        $user = User::factory()->create();
        $member = $user->member;
        $course = Course::factory()->create([
            'name' => 'QAC 1.0 Lite 1a',
            'is_lite' => true,
            'level' => 0,
        ]);
        $batch = Batch::factory()->create([
            'course_id' => $course->id,
            'name' => 'online',
        ]);

        $approvedAt = Carbon::parse('2026-10-27 09:00:00');
        $memberBatch = MemberBatch::create([
            'member_id' => $member->id,
            'batch_id' => $batch->id,
            'status' => MemberBatch::STATUS_REGISTERED,
            'session' => null,
        ]);
        $memberBatch->status = MemberBatch::STATUS_PAID;
        $memberBatch->approved_at = $approvedAt;

        (new UpdateLiteBatch)->handle(new MemberBatchUpdated($memberBatch));

        $order = Order::where('member_id', $member->id)->first();
        $this->assertSame(3, (int) $order->months);
        $this->assertSame('2027-01-27', $order->end_date->format('Y-m-d'));

        $memberBatch->save();
        $this->assertSame(
            '27 Oct 2026 s/d 27 Jan 2027',
            AppHelper::liteduration($memberBatch->id)
        );
    }
}
