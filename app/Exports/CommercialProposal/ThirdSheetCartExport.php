<?php

namespace App\Exports\CommercialProposal;

use App\Classes\DocumentLogic;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;


class ThirdSheetCartExport implements FromView
{
    public $items;
    private $sheetTitle;

    public $buyer;

    public function __construct($data, $sheetTitle = "В виде таблицы", $buyer = null)
    {
        $this->items = $data ?? [];
        $this->sheetTitle = $sheetTitle;
        $this->buyer = $buyer;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $doc = new DocumentLogic();

        return view('export.tasks', [
            'items' => $this->items,

        ]);
    }



}
