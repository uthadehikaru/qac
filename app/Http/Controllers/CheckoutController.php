<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecourse;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index(Ecourse $ecourse)
    {
        $data['ecourse'] = $ecourse;
        session()->put('url.intended',url()->current());
        return view('checkout.form', $data);
    }
    
    public function store(Request $request, OrderService $orderService, Ecourse $ecourse)
    {
        $data = [
            'member_id' => Auth::user()->member->id,
            'ecourse_id' => $ecourse->id,
            'price' => $ecourse->price_sell,
            'months' => $request->months,
            'total' => $request->months*$ecourse->price_sell,
        ];
        $orderService->create($data);
        
        return redirect()->route('member.orders.index');
    }
}
