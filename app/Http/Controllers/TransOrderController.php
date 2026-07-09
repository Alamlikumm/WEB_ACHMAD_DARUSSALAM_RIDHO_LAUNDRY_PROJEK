<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransOrder;
use App\Models\TransOrderDetail;
use App\Models\Customer;
use App\Models\TypeOfService;

class TransOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = TransOrder::with(['customer', 'orderDetails.service']);
        
        if ($request->filled('search')) {
            $query->where('order_code', 'like', '%' . $request->search . '%')
                  ->orWhereHas('customer', function($q) use ($request) {
                      $q->where('customer_name', 'like', '%' . $request->search . '%');
                  });
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $services = TypeOfService::all();
        return view('orders.create', compact('customers',
         'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_customer' => 'required|exists:customers,id',
            'order_date' => 'required|date|after_or_equal:today',
            'order_end_date' => 'required|date|after_or_equal:order_date',
            'tax_percent' => 'required|numeric|min:0',
            'order_pay' => 'required|integer|min:0',
            'payment_method' => 'required|in:Cash,QRIS',
            'services' => 'required|array|min:1',
            'services.*.id_service' => 'required|exists:type_of_services,id',
            'services.*.qty' => 'required|numeric|min:0.1',
            'services.*.notes' => 'nullable|string',
        ]);

        // Generate order code
        $orderCode = 'LAUNDRY-' . date('Ymd') . '-' . str_pad(
            TransOrder::withTrashed()->count() + 1,
            4,
            '0',
            STR_PAD_LEFT
        );

        // Hitung subtotal semua item
        $subtotalAll = 0;
        foreach ($request->services as $item) {
            $service = TypeOfService::find($item['id_service']);
            $subtotalAll += $service->price * $item['qty'];
        }

        // Hitung pajak dan total
        $tax = $subtotalAll * ($request->tax_percent / 100);
        $total = $subtotalAll + $tax;

        // Validasi pembayaran: Tidak ada bayar sebagian. Harus lunas atau 0 (bayar nanti)
        if ($request->order_pay > 0 && $request->order_pay < $total) {
            return back()->withErrors(['order_pay' => 'Uang kurang! Tidak bisa bayar sebagian. Total tagihan adalah Rp ' . number_format($total, 0, ',', '.') . '.'])->withInput();
        }

        // Buat order utama
        $order = TransOrder::create([
            'id_customer' => $request->id_customer,
            'order_code' => $orderCode,
            'order_date' => $request->order_date,
            'order_end_date' => $request->order_end_date,
            'order_status' => 0,
            'order_pay' => $request->order_pay,
            'payment_method' => $request->payment_method,
            'order_change' => $request->order_pay - $total,
            'total' => $total,
        ]);

        // Buat detail per item
        foreach ($request->services as $item) {
            $service = TypeOfService::find($item['id_service']);
            TransOrderDetail::create([
                'id_order' => $order->id,
                'id_service' => $item['id_service'],
                'qty' => $item['qty'],
                'subtotal' => $service->price * $item['qty'],
                'notes' => $item['notes'] ?? null,
            ]);
        }

        return redirect()->route('orders.index')->with
        ('success', 'Transaksi Berhasil Dibuat');
    }

    public function show(TransOrder $order)
    {
        $order->load(['customer', 'orderDetails.service']);
        return view('orders.show', compact('order'));
    }
}
