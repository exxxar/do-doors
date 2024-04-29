<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class OrderPageExport implements FromView
{
    public $orders;
    private $sheetTitle;

    public function __construct($orders = [], $sheetTitle)
    {
        $this->orders= $orders ?? [];
        $this->sheetTitle = $sheetTitle;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.orders', [
            'orders' => $this->orders,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
