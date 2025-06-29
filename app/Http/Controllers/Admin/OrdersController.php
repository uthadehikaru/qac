<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrdersDataTable $dataTable)
    {
        $activeOrders = Order::active()->count();
        $data['title'] = __('Orders').' ('.$activeOrders.' aktif)';

        return $dataTable->render('admin.datatable', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['order'] = null;

        return view('admin.order-form', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, OrderService $orderService)
    {
        $data = $request->only(['start_date', 'end_date']);
        $data['id'] = null;
        $total = $orderService->addAllPaidMembers($data);

        return redirect()->route('admin.orders.index')->with('message', $total.' Order added');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);

        if ($order) {
            $order->delete();

            return response()->json(['status' => 'Deleted successfully']);
        } else {
            return response()->json(['status' => 'No Order Found for id '.$id], 404);
        }
    }
}
