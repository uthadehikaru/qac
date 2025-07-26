<?php

namespace Tests\Feature\Admin;

use App\Events\MemberBatchUpdated;
use App\Listeners\UpdateLiteBatch;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Models\Order;
use App\Models\System;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\SystemSeeder;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class LiteTest extends TestCase
{

    protected $lite1a;
    protected $lite1b;
    protected $batch1a;
    protected $batch1b;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(SystemSeeder::class);
        $this->lite1a = Course::factory()->create([
            'name' => 'QAC 1.0 Lite 1a',
            'is_lite' => true,
            'level' => 0,
        ]);
        $this->batch1a = Batch::factory()->create([
            'name' => 'online',
            'course_id' => $this->lite1a->id,
            'start_at' => now()->addDays(1),
            'end_at' => now()->addDays(2),
            'registration_start_at' => now()->subDays(1),
            'registration_end_at' => now()->addDays(1),
        ]);
        $this->lite1b = Course::factory()->create([
            'name' => 'QAC 1.0 Lite 1b',
            'is_lite' => true,
            'level' => 1,
        ]);
        $this->batch1b = Batch::factory()->create([
            'name' => 'online',
            'course_id' => $this->lite1b->id,
            'start_at' => now()->addDays(1),
            'end_at' => now()->addDays(2),
            'registration_start_at' => now()->subDays(1),
            'registration_end_at' => now()->addDays(1),
        ]);
        System::where('key', 'ecourse_access_months')->update(['value' => 1]);
        System::where('key', 'qac_1_lite_1a')->update(['value' => $this->lite1a->id]);
        System::where('key', 'qac_1_lite_1b')->update(['value' => $this->lite1b->id]);
    }

    public function test_lite_registration()
    {
        Event::fake();

        $user = [
            'full_name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
        $response = $this->post(route('register', $user));
        $response->assertSessionDoesntHaveErrors();
        $response->assertStatus(302);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('members', [
            'full_name' => 'Test User',
        ]);

        $member = [
            'batch_id' => $this->batch1a->id,
            'course_id' => $this->lite1a->id,
            'lite' => true,
            'full_name' => 'Test User',
            'phone' => '6281212345678',
            'job' => 'jobless',
            'education' => 'S1',
            'province' => 'Jakarta',
            'regency' => 'Jakarta Selatan',
            'package' => 'bundling',
        ];
        $response = $this->post(route('kelas.register', $member));
        $response->assertSessionDoesntHaveErrors();
        $response->assertStatus(302);

        $member = User::where('email', $user['email'])->first()->member;

        $memberBatch1a = MemberBatch::where('batch_id', $this->batch1a->id)
        ->where('member_id', $member->id)
        ->where('session', 'bundling')
        ->first();
        $this->assertNotNull($memberBatch1a);
        $this->assertEquals(MemberBatch::STATUS_REGISTERED, $memberBatch1a->status);

        $memberBatch1b = MemberBatch::where('batch_id', $this->batch1b->id)
        ->where('member_id', $member->id)
        ->where('session', 'bundling')
        ->first();
        $this->assertNotNull($memberBatch1b);
        $this->assertEquals(MemberBatch::STATUS_REGISTERED, $memberBatch1b->status);

        $memberBatch1a->status = MemberBatch::STATUS_PAID;
        $memberBatch1a->save();

        Event::assertDispatched(MemberBatchUpdated::class);
        $updateLiteBatch = new UpdateLiteBatch();
        $updateLiteBatch->handle(new MemberBatchUpdated($memberBatch1a));

        $memberBatch1b->refresh();
        $this->assertEquals(MemberBatch::STATUS_GRADUATED, $memberBatch1b->status);

        $order = Order::where('member_id', $member->id)->first();
        $this->assertNotNull($order);
        $this->assertNotNull($order->end_date);
    }
} 