<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;


class PriceExport implements FromView
{
    public $prices;
    public $materials;
    public function __construct($data = [])
    {
        $this->prices = $data["prices"] ?? [];
        $this->materials = $data["materials"] ?? [];
    }

    public function view():\Illuminate\Contracts\View\View
    {
        return view('export.prices', [
            'prices' => $this->prices,
            'materials' => $this->materials
        ]);
    }
}
