<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;


class PriceExport implements  WithMultipleSheets
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
            new PricePageExport($this->data,'wholesale',"Опт"),
            new PricePageExport($this->data,'dealer',"Дилер"),
            new PricePageExport($this->data,'retail',"Розница"),
            new PricePageExport($this->data,'cost',"Себестоимость"),
        ];
    }
}
