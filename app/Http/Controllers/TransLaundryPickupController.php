<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransLaundryPickup;
use App\Models\TransOrder;

class TransLaundryPickupController extends Controller
{
    public function index(Request $request)
    {
        $query = TransLaundryPickup::with(['order', 'customer']);
        
        if ($request->filled('search')) {
            $query->whereHas('order', function($q) use ($request) {
                      $q->where('order_code', 'like', '%' . $request->search . '%');
                  })
                  ->orWhereHas('customer', function($q) use ($request) {
                      $q->where('customer_name', 'like', '%' . $request->search . '%');
                  });
        }
        
        $pickups = $query->orderBy('pickup_date', 'desc')->paginate(10);

        return view('pickups.index', compact('pickups'));
    }

    public function create()
    {
        $orders = TransOrder::with('customer')
            ->where('order_status', 0)
            ->get();

        return view('pickups.create', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_order' => 'required|exists:trans_orders,id',
            'pickup_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string',
        ]);

        $order = TransOrder::find($request->id_order);

        // Double check: pastikan belum diambil
        if ($order->order_status != 0) {
            return back()->withErrors([
                'id_order' => 'Order ini sudah diambil sebelumnya.',
            ]);
        }

        TransLaundryPickup::create([
            'id_order' => $request->id_order,
            'id_customer' => $order->id_customer,
            'pickup_date' => $request->pickup_date,
            'pickup_time' => date('H:i'), // Tambahkan waktu otomatis
            'notes' => $request->notes,
        ]);

        // Jika sebelumnya kurang bayar (hutang), otomatis dilunasi saat pengambilan
        $updateData = ['order_status' => 1];
        if ($order->order_pay < $order->total) {
            $updateData['order_pay'] = $order->total;
            $updateData['order_change'] = 0;
        }
        $order->update($updateData);

        return redirect()->route('pickups.index')->with('success', 'Pengambilan laundry berhasil dicatat');
    }
}