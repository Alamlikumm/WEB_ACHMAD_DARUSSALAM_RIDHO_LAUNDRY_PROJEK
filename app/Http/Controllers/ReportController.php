<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TransOrder;
use App\Exports\LaporanPenjualanExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = TransOrder::with(['customer', 'orderDetails.service']);

        // Filter: tanggal
        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('order_date', [$request->from, $request->to]);
        }

        // Filter: status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('order_status', $request->status);
        }

        $orders = $query->orderBy('order_date', 'desc')->get();

        // Statistik
        $totalRevenue = $orders->sum('total');
        $totalOrders = $orders->count();
        $pickedUp = $orders->where('order_status', 1)->count();
        $pending = $orders->where('order_status', 0)->count();

        return view('reports.index', compact(
            'orders',
            'totalRevenue',
            'totalOrders',
            'pickedUp',
            'pending'
        ));
    }
    public function exportExcel(Request $request)
    {
        $orders = $this->getFilteredData($request);
        return Excel::download(new LaporanPenjualanExport($orders), 'laporan-penjualan.xlsx');
    }

        public function exportPdf(Request $request)
    {
        $orders = $this->getFilteredData($request);
        
    
        $pdf = Pdf::loadView('reports.export', compact('orders'));
        
        return $pdf->download('laporan-penjualan.pdf');
    }


    private function getFilteredData(Request $request)
    {
        $query = TransOrder::with(['customer', 'orderDetails.service']);

        if ($request->filled('from') && $request->filled('to')) {
            $query->whereBetween('order_date',
             [$request->from, $request->to]);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('order_status', $request->status);
        }

        return $query->orderBy('order_date', 'desc')->get();
    }
}
