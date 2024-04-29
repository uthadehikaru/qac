<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Notifications\MemberOrderConfirmed;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmOrder extends Controller
{
    public function __invoke(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        DB::transaction(function () use ($order) {

            $activeOrder = Order::active()
                ->where('member_id', $order->member_id)
                ->latest('end_date')
                ->first();

            $start_date = null;
            $end_date = null;
            if ($activeOrder) {
                $start_date = $activeOrder->end_date;
                $end_date = $activeOrder->end_date->addMonths($order->months);
            } else {
                $start_date = CarbonImmutable::now()->startOfDay();
                $end_date = CarbonImmutable::now()->addMonths($order->months)->startOfDay();
            }

            $order->update([
                'start_date' => $start_date,
                'end_date' => $end_date,
                'verified_at' => Carbon::now(),
            ]);
        });

        $order->member->user->notify(new MemberOrderConfirmed($order));

        return back()->with('message', 'Confirmed');
    }
}
