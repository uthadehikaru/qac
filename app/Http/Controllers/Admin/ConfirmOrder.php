<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\MemberOrderConfirmed;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConfirmOrder extends Controller
{
    public function __invoke(Request $request, $order_id)
    {
        $order = Order::find($order_id);
        DB::transaction(function() use($order){

            $activeSubscription = Subscription::active()
            ->where('member_id',$order->member_id)
            ->latest('end_date')
            ->first();

            $start_date = null;
            $end_date = null;
            if($activeSubscription){
                $start_date = $activeSubscription->end_date;
                $end_date = $activeSubscription->end_date->addMonths($order->months);
            }else{
                $start_date = CarbonImmutable::now();
                $end_date = CarbonImmutable::now()->addMonths($order->months);
            }

            $subscription = Subscription::create([
                'ecourse_id' => $order->ecourse_id,
                'member_id' => $order->member_id,
                'start_date' => $start_date,
                'end_date' => $end_date,
            ]);

            $order->verified_at = Carbon::now();
            $order->subscription_id = $subscription->id;
            $order->save();
        });

        $order->member->user->notify(new MemberOrderConfirmed($order));

        return back()->with('message','Confirmed');
    }
}
