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


class SecondSheetCartExport implements FromView, WithStyles, WithEvents
{
    public $items;

    public $otherProducts;

    private $sheetTitle;

    public $buyer;

    public function __construct($data,$otherProducts = null, $sheetTitle = "Коммерческое предложение", $buyer = null)
    {
        $this->items = $data ?? [];
        $this->sheetTitle = $sheetTitle;
        $this->buyer = $buyer;
        $this->otherProducts = $otherProducts ?? null;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $doc = new DocumentLogic();

        return view('export.cart-part3', [
            'items' => $this->items,
            'sheet_title' => $this->sheetTitle,
            'seller' => $doc->getAllSellerParameters(),
            'buyer' => $this->buyer,
            'other_products' => $this->otherProducts,
        ]);
    }



    public function registerEvents(): array
    {


        return [
            AfterSheet::class => function (AfterSheet $event) {

                $count = count($this->items) + count($this->otherProducts ?? []) + 3;
                $startPosTable2 = $count + 2;
                $endPosTable2 = $startPosTable2 + 11;

                $sheet = $event->sheet->getDelegate();


                $stampEndPos = $endPosTable2 + 25;
                // Устанавливаем область печати (например, A1:D20)
                $sheet->getPageSetup()->setPrintArea("A1:J$stampEndPos");

                // Устанавливаем ориентацию страницы (книжная или альбомная)
                $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT); // Альбомная
                // $sheet->getPageSetup()->setOrientation(PageSetup::ORIENTATION_PORTRAIT); // Книжная

                // Устанавливаем масштабирование (100% - без изменений)
                $sheet->getPageSetup()->setScale(100);

                // Включаем автоматическое подгонку колонок под страницу
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);
            },
        ];
    }

    public function styles(Worksheet|\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet $sheet)
    {
        $count = count($this->items) + count($this->otherProducts ?? []) + 3;
        $startPosTable2 = $count + 2;
        $endPosTable2 = $startPosTable2 + 11;
        return [
            '2' => [
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'ADD8E6'], // Светло-голубой цвет (LightBlue)
                ],
            ],
            "B2:D$count" => [ // Укажите диапазон таблицы
                'alignment' => [
                    'wrapText' => true,
                ],
            ],
            "A2:J$count" => [ // Укажите диапазон таблицы
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN, // Жирные границы
                        'color' => ['rgb' => '000000'], // Цвет границ (черный)
                    ],
                ],
            ],
            /*  "A$startPosTable2:I$endPosTable2" => [ // Укажите диапазон таблицы
                  'borders' => [
                      'allBorders' => [
                          'borderStyle' => Border::BORDER_THIN, // Жирные границы
                          'color' => ['rgb' => '000000'], // Цвет границ (черный)
                      ],
                  ],
              ],*/
            'A1:A500' => [ // Диапазон ячеек
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Выравнивание по верхнему краю
                ],

            ],
            'B1:Z500' => [ // Диапазон ячеек
                'alignment' => [
                    'wrapText' => true, // Включение переноса строк
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP, // Выравнивание по верхнему краю
                ],

            ],

        ];
    }
}
