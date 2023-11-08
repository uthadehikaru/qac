<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ecourse;

class CheckoutController extends Controller
{
    public function index(Ecourse $ecourse)
    {
        $data['ecourse'] = $ecourse;
        session()->put('url.intended',url()->current());
        return view('checkout.form', $data);
    }
    
    public function payment(Ecourse $ecourse)
    {
        $data['ecourse'] = $ecourse;
        return view('checkout.payment', $data);
    }
}
