<?php

namespace App\Services;

use App\Models\Member;
use App\Models\Order;
use App\Models\User;
use App\Notifications\AdminNewOrder;
use App\Notifications\MemberNewOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function create($data)
    {
        $order = Order::create($data);

        $order->member->user->notify(new MemberNewOrder($order));
        foreach (User::admin() as $admin) {
            $admin->notify(new AdminNewOrder($order));
        }
    }

    public function addAllPaidMembers($data)
    {
        $members = Member::whereHas('paidBatches')->pluck('id');
        $total = 0;
        foreach ($members as $member_id) {
            $activeOrder = Order::where('member_id', $member_id)->verified()->latest()->first();
            if ($activeOrder) {
                continue;
            }

            $data['member_id'] = $member_id;
            $data['months'] = 0;
            $data['verified_at'] = Carbon::now();
            Order::create($data);
            $total++;
        }

        return $total;
    }

    public function activeOrder()
    {
        return Order::where('member_id', Auth::user()->member?->id)->verified()->latest()->first();
    }
}
