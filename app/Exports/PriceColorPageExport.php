<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PriceColorPageExport implements FromView
{
    public $prices;
    public $names;
    private $sheetTitle;

    public function __construct($data = [], $sheetTitle = "Цвета")
    {
        $this->prices = $data["colors"] ?? [];
        $this->names = $data["color_names"] ?? [];
        $this->sheetTitle = $sheetTitle;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.price-color', [
            'prices' => $this->prices,
            'names' => $this->names,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
