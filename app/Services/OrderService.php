<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use App\Notifications\AdminNewOrder;
use App\Notifications\MemberNewOrder;

class OrderService {

    public function create($data){
        $order = Order::create($data);
        
        $order->member->user->notify(new MemberNewOrder($order));
        foreach(User::admin() as $admin)
            $admin->notify(new AdminNewOrder($order));
    }
}