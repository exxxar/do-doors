<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class CartExport implements FromView
{
    public $items;
    private $sheetTitle;

    public function __construct($data, $sheetTitle = "Корзина")
    {
        $this->items = $data ?? [];
        $this->sheetTitle = $sheetTitle;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.cart', [
            'items' => $this->items,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
