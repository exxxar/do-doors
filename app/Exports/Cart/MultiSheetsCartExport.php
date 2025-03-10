<?php

namespace App\Exports\Cart;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetsCartExport implements WithMultipleSheets
{
    public $items;

    public $buyer;

    public function __construct($data, $buyer)
    {
        $this->items = $data ?? [];
        $this->buyer = $buyer;

    }

    public function sheets(): array
    {
        return [
            new SecondSheetCartExport(data: $this->items, buyer: $this->buyer),
            new FirstSheetCartExport(data: $this->items),
            //new ThirdSheetCartExport(data: $this->items),
        ];
    }
}
