<?php

namespace App\Exports\Cart;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Worksheet;


class FirstSheetCartExport implements FromView, WithStyles
{
    public $items;
    private $sheetTitle;

    public function __construct($data, $sheetTitle = "Формирование наименования")
    {
        $this->items = $data ?? [];
        $this->sheetTitle = $sheetTitle;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        return view('export.cart-part1', [
            'items' => $this->items,
            'sheet_title' => $this->sheetTitle,
        ]);
    }

    public function styles(Worksheet|\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        return [
            '2'=>[
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'ADD8E6'], // Светло-голубой цвет (LightBlue)
                ],
            ],
            'A2:AZ100' => [ // Укажите диапазон таблицы
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN, // Жирные границы
                        'color' => ['rgb' => '000000'], // Цвет границ (черный)
                    ],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_TOP, // Выравнивание по верхнему краю
                    'wrapText' => true,
                ],
            ],

        ];
    }
}
