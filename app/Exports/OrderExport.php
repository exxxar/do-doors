<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class OrderExport  implements  WithMultipleSheets
{
    use \Maatwebsite\Excel\Concerns\Exportable;

    public $orders;
    public $tasks;

    public function __construct($orders = [], $tasks = [])
{
    $this->orders = $orders;
    $this->tasks = $tasks;
}

    public function sheets(): array
{
    return [
        new OrderPageExport($this->orders,"Заказы"),
        new TaskPageExport($this->tasks,"Заявки на производство"),
    ];
}
}
