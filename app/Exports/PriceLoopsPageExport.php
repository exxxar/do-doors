<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PriceLoopsPageExport implements FromView
{
    public $loops;
    public $materials;
    private $sheetTitle;

    public function __construct($data = [], $sheetTitle = "Петли")
    {
        $this->loops = $data["loops"] ?? [];
        $this->materials = $data["materials"] ?? [];
        $this->sheetTitle = $sheetTitle;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.price-loops', [
            'prices' => $this->loops,
            'materials' => $this->materials,
            'sheet_title' => $this->sheetTitle,
        ]);
    }
}
