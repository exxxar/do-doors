<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PriceMultiSheetImport implements WithMultipleSheets
{


    public function sheets(): array
    {
        return [
            new PriceSizeLoopsImport("sizes"),
            new PriceSizeLoopsImport("loops"),
            new PriceDepthImport(),
            new PriceColorsImport(),
        ];
    }
}
