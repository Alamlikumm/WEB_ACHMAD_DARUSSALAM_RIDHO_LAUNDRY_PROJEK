<?php

namespace App\Exports;

use App\Models\TransOrder;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPenjualanExport implements FromView
{
    protected $orders;

    public function __construct($orders)
    {
        $this->orders = $orders;
    }

    public function view(): View
    {
        return view('reports.export', [
            'orders' => $this->orders
        ]);
    }

}
