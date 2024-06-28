<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PriceSizesPageExport implements FromView
{
    public $sizes;
    public $materials;
    private $sheetTitle;

    public function __construct($data = [], $sheetTitle = "Размеры")
    {
        $this->sizes = $data["sizes"] ?? [];
        $this->materials = $data["materials"] ?? [];
        $this->sheetTitle = $sheetTitle;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.price-sizes', [
            'prices' => $this->sizes,
            'materials' => $this->materials,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
