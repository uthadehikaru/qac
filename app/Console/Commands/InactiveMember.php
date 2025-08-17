<?php

namespace App\Console\Commands;

use App\Models\Member;
use App\Models\Order;
use App\Models\System;
use App\Notifications\InactiveMemberReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class InactiveMember extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:inactive-member';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check inactive member and send reminder emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $inactiveDays = System::value('inactive_days', 3);
        $cutoffDate = Carbon::now()->subDays($inactiveDays);
        
        Log::info("Checking for members inactive for {$inactiveDays} days (since {$cutoffDate->format('Y-m-d')})");
        $this->info("Checking for members inactive for {$inactiveDays} days (since {$cutoffDate->format('Y-m-d')})");
        
        // Get members with active orders
        $activeMembers = Member::whereHas('orders', function ($query) {
            $query->active()->verified();
        })->with(['orders' => function ($query) {
            $query->active()->verified()->orderBy('start_date', 'desc');
        }, 'user'])->get();
        
        $this->info("Found " . $activeMembers->count() . " members with active orders");
        
        $inactiveMembers = collect();
        
        foreach ($activeMembers as $member) {
            // Check if member has completed any lessons
            $lastCompletedLesson = $member->completedLessons()
                ->orderBy('created_at', 'desc')
                ->first();
            
            $isInactive = false;
            $actualInactiveDays = $inactiveDays;
            $order = $member->orders()->first();
            
            if ($lastCompletedLesson && $lastCompletedLesson->created_at->gte($order->start_date)) {
                // If member has completed lessons, check if the last one was within inactive_days
                $daysSinceLastLesson = Carbon::now()->diffInDays($lastCompletedLesson->created_at);
                if ($daysSinceLastLesson == $inactiveDays) {
                    $isInactive = true;
                    $actualInactiveDays = $daysSinceLastLesson;
                }
            } else {
                // If member has never completed any lessons, check from the start date of their active order
                $activeOrder = $member->orders()
                    ->active()
                    ->verified()
                    ->orderBy('start_date', 'desc')
                    ->first();
                
                if ($activeOrder) {
                    $daysSinceOrderStart = Carbon::now()->diffInDays($activeOrder->start_date);
                    if ($daysSinceOrderStart == $inactiveDays) {
                        $isInactive = true;
                        $actualInactiveDays = $daysSinceOrderStart;
                    }
                }
            }
            
            if ($isInactive) {
                $member->actualInactiveDays = $actualInactiveDays;
                $inactiveMembers->push($member);
            }
        }
        
        Log::info("Found " . $inactiveMembers->count() . " inactive members (inactive for " . $inactiveDays . "+ days)");
        $this->info("Found " . $inactiveMembers->count() . " inactive members (inactive for " . $inactiveDays . "+ days)");
        
        // Send notifications to inactive members
        $sentCount = 0;
        foreach ($inactiveMembers as $member) {
            try {
                if ($member->user && $member->user->email) {
                    $actualInactiveDays = $member->actualInactiveDays ?? $inactiveDays;
                    $activeOrder = $member->orders()->active()->verified()->first();
                    $orderDuration = $activeOrder ? $activeOrder->start_date->format('d M Y') . ' - ' . $activeOrder->end_date->format('d M Y') : 'No active order';
                    $member->user->notify(new InactiveMemberReminder($member, $actualInactiveDays));
                    $sentCount++;
                    Log::info("Sent reminder to: {$member->full_name} ({$member->user->email}) - {$actualInactiveDays} days inactive - Order: {$orderDuration}");
                    $this->line("Sent reminder to: {$member->full_name} ({$member->user->email}) - {$actualInactiveDays} days inactive - Order: {$orderDuration}");
                } else {
                    Log::info("No email found for member: {$member->full_name}");
                    $this->warn("No email found for member: {$member->full_name}");
                }
            } catch (\Exception $e) {
                Log::error("Failed to send reminder to {$member->full_name}: " . $e->getMessage());
                $this->error("Failed to send reminder to {$member->full_name}: " . $e->getMessage());
            }
        }
        
        $this->info("Successfully sent {$sentCount} reminder emails");
        
        return 0;
    }
}
