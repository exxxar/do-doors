<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;


class PricePageExport implements FromView
{
    public $prices;
    public $materials;
    private $sheetTitle;
    private $priceParam;

    public function __construct($data = [], $priceParam, $sheetTitle)
    {
        $this->prices = $data["prices"] ?? [];
        $this->materials = $data["materials"] ?? [];
        $this->sheetTitle = $sheetTitle;
        $this->priceParam = $priceParam;
    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.prices', [
            'prices' => $this->prices,
            'materials' => $this->materials,
            'sheet_title' => $this->sheetTitle,
            'price_type' => $this->priceParam
        ]);
    }
}
