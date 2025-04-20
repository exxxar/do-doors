<?php

namespace App\Exports\CommercialProposal;


use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultiSheetsCart2Export implements WithMultipleSheets
{
    public $items;

    public $otherProducts;

    public $buyer;

    public $single;

    public function __construct($data, $buyer, $otherProducts = null, $single = false)
    {
        $this->items = $data ?? [];
        $this->buyer = $buyer;
        $this->single = $single;
        $this->otherProducts = $otherProducts;
    }

    public function sheets(): array
    {
        if ($this->single)
            return [
                new SecondSheetCartExport(data: $this->items, otherProducts: $this->otherProducts, buyer: $this->buyer),
            ];
        else
            return [
                new SecondSheetCartExport(data: $this->items,otherProducts: $this->otherProducts, buyer: $this->buyer),
                // new FirstSheetCartExport(data: $this->items),
                new ThirdSheetCartExport(data: $this->items),
            ];
    }
}
