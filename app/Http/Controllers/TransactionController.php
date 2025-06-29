<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Service;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::orderBy('id', 'DESC')->get();
        return view('transaction.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::orderBy('id', 'DESC')->get();
        return view('transaction.create', compact('services'));
    }

    public function searchCustomer(Request $request){
        $v = $request->query('q');
        $customers = Customer::where('customer_name', 'LIKE', "%{$v}%")->get();

        return response()->json($customers);
      
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $order = Order::create([
            'id_customer' => $request->id_customer, 
            'order_code' => $request->order_code, 
            'order_date' => $request->order_date, 
            'order_end_date' => $request->order_end_date, 
            'total' => $request->total
        ]);

        foreach ($request->id_service as $index => $id_srcvs) {
            OrderDetail::create([
                'id_order' => $order->id, 
                'id_service' => $id_srcvs, 
                'qty' => $request->qty[$index], 
                'subtotal' => $request->subtotal[$index], 
                'notes' => $request->notes[$index]
            ]);
        }

        return redirect()->route('transaction')->with('status', 'Berhasil di Order!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         $order = Order::with([
            'customer', 'orderDetail.service',
         ])->findOrFail($id);
        return view('transaction.show', compact('order'));
    }

    public function paid(Request $request, string $id)
    {
        $order = Order::findOrFail($id);
        $order->order_pay = $request->order_pay;
        $order->order_change = $request->order_change;
        $order->order_status = 0;
        $order->save();

        return redirect()->route('transaction')->with('status', 'Berhasil dibayar');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
