<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PriceV3Export implements WithMultipleSheets
{
    use Exportable;

    public $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            new PriceSizesPageExport($this->data, 'Размеры'),
            new PriceLoopsPageExport($this->data, 'Петли'),
            new PriceDepthPageExport($this->data, 'Толщина'),
            new PriceColorPageExport($this->data, 'Цвет'),
        ];
    }
}
