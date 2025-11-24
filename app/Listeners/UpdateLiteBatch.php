<?php

namespace App\Listeners;

use App\Events\MemberBatchUpdated;
use App\Models\MemberBatch;
use App\Models\Order;
use App\Models\System;
use App\Services\OrderService;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateLiteBatch
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
    public function handle(MemberBatchUpdated $event): void
    {
        $isLite = $event->memberBatch->batch->course->is_lite;
        if ($isLite) {
            // Only create order when status changes from REGISTERED to PAID
            $originalStatus = $event->memberBatch->getOriginal('status');
            $currentStatus = $event->memberBatch->status;
            
            if ($originalStatus == MemberBatch::STATUS_REGISTERED && $currentStatus == MemberBatch::STATUS_PAID) {
                if($event->memberBatch->session == 'bundling') {
                    MemberBatch::where('member_id', $event->memberBatch->member_id)
                        ->where('batch_id', '!=', $event->memberBatch->batch_id)
                        ->where('session', 'bundling')
                        ->where('status', MemberBatch::STATUS_REGISTERED)
                        ->update([
                            'status' => $event->memberBatch->status,
                            'approved_at' => now(),
                        ]);
                }
                $months = System::value('ecourse_access_months',1);
                if($event->memberBatch->session == 'bundling') {
                    $months = $months * 2;
                }
                $activeOrder = Order::where('member_id', $event->memberBatch->member_id)->verified()->latest()->first();
                $startDate = CarbonImmutable::now();
                $endDate = CarbonImmutable::now();
                if ($activeOrder && $activeOrder->end_date > $startDate) {
                    $startDate = $activeOrder->end_date;
                    $endDate = $activeOrder->end_date->addMonths($months);
                }else{
                    $endDate = $startDate->addMonths($months);
                }
                Order::create([
                    'member_id' => $event->memberBatch->member_id,
                    'start_date' => $startDate,
                    'price' => 0,
                    'months' => $months,
                    'total' => 0,
                    'end_date' => $endDate,
                    'verified_at' => Carbon::now(),
                ]);
            }
        }
    }
}
