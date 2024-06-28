<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PriceDepthPageExport implements FromView
{
    public $prices;
    private $sheetTitle;
    private $names;

    public function __construct($data = [], $sheetTitle = "Толщина")
    {
        $this->prices = $data["variants"] ?? [];
        $this->names = $data["depth_names"] ?? [];
        $this->sheetTitle = $sheetTitle;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.price-depth', [
            'prices' => $this->prices,
            'names' => $this->names,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
