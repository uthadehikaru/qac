<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\OrdersDataTable;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Section;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(OrdersDataTable $dataTable)
    {
        $data['title'] = 'Orders';
        $data['button'] = '<a class="ml-3 inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 float-right" href="'.route('admin.ecourses.index').'">Back</a>';

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
