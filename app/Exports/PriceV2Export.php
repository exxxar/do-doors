<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PriceV2Export implements FromView
{
    public $prices;
    public $materials;
    private $sheetTitle;

    public function __construct($data = [], $sheetTitle = "Цены")
    {
        $this->prices = $data["prices"] ?? [];
        $this->materials = $data["materials"] ?? [];
        $this->sheetTitle = $sheetTitle;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.prices-v2', [
            'prices' => $this->prices,
            'materials' => $this->materials,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
