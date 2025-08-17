<?php

namespace Tests\Feature;

use App\Models\Member;
use App\Models\Order;
use App\Models\System;
use App\Models\User;
use App\Notifications\InactiveMemberReminder;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class InactiveMemberCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_inactive_member_command_sends_reminders()
    {
        Notification::fake();

        // Set up system configuration
        System::create([
            'key' => 'inactive_days',
            'value' => '3',
            'is_array' => false
        ]);

        // Create a user and member
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);
        
        $member = Member::factory()->create([
            'user_id' => $user->id,
            'full_name' => 'Test Member'
        ]);

        // Create an active order for the member
        Order::factory()->create([
            'member_id' => $member->id,
            'verified_at' => now(),
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(10)
        ]);

        // Run the command
        $this->artisan('app:inactive-member')
             ->assertExitCode(0);

        // Assert that notification was sent
        Notification::assertSentTo(
            $user,
            InactiveMemberReminder::class,
            function ($notification) use ($member) {
                return $notification->member->id === $member->id;
            }
        );
    }

    public function test_inactive_member_command_does_not_send_to_active_members()
    {
        Notification::fake();

        // Set up system configuration
        System::create([
            'key' => 'inactive_days',
            'value' => '3',
            'is_array' => false
        ]);

        // Create a user and member
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);
        
        $member = Member::factory()->create([
            'user_id' => $user->id,
            'full_name' => 'Test Member'
        ]);

        // Create an active order for the member
        Order::factory()->create([
            'member_id' => $member->id,
            'verified_at' => now(),
            'start_date' => now()->subDays(10),
            'end_date' => now()->addDays(10)
        ]);

        // Create a completed lesson within the last 3 days (active member)
        $member->completedLessons()->create([
            'lesson_id' => 1,
            'created_at' => now()->subDays(1)
        ]);

        // Run the command
        $this->artisan('app:inactive-member')
             ->assertExitCode(0);

        // Assert that no notification was sent
        Notification::assertNotSentTo($user, InactiveMemberReminder::class);
    }

    public function test_inactive_member_command_sends_reminder_for_member_with_no_completed_lessons()
    {
        Notification::fake();

        // Set up system configuration
        System::create([
            'key' => 'inactive_days',
            'value' => '3',
            'is_array' => false
        ]);

        // Create a user and member
        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);
        
        $member = Member::factory()->create([
            'user_id' => $user->id,
            'full_name' => 'Test Member No Lessons'
        ]);

        // Create an active order for the member that started 5 days ago
        Order::factory()->create([
            'member_id' => $member->id,
            'verified_at' => now(),
            'start_date' => now()->subDays(5),
            'end_date' => now()->addDays(10)
        ]);

        // Run the command
        $this->artisan('app:inactive-member')
             ->assertExitCode(0);

        // Assert that notification was sent with correct inactive days
        Notification::assertSentTo(
            $user,
            InactiveMemberReminder::class,
            function ($notification) use ($member) {
                return $notification->member->id === $member->id && $notification->inactiveDays >= 3;
            }
        );
    }
}
