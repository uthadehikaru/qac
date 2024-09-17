<?php

namespace App\Http\Controllers;

use App\Models\Ecourse;
use App\Models\Member;
use App\Models\MemberBatch;
use App\Models\Order;
use App\Models\System;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $data['ecourses'] = Ecourse::published()->get();
        $data['order'] = Order::where('member_id', Auth::user()->member->id)->whereNull('verified_at')->first();
        session()->put('url.intended', url()->current());
        
        $member = Member::with(['batches', 'courses'])->where('user_id', Auth::id())->first();
        $data['alumni'] = $member->batches->contains(function ($memberBatch, $key) {
            return $memberBatch->pivot->status>=MemberBatch::STATUS_PAID;
        });

        return view('checkout.form', $data);
    }

    public function store(Request $request, OrderService $orderService)
    {
        $data = [
            'member_id' => Auth::user()->member->id,
            'price' => System::value('subscription_fee'),
            'months' => $request->months,
            'total' => $request->months * System::value('subscription_fee'),
        ];
        $orderService->create($data);

        return redirect()->route('member.orders.index');
    }
}
