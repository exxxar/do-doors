<?php

namespace App\Exports\Cart;

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


class SecondSheetCartExport implements FromView, WithStyles, WithEvents, WithDrawings
{
    public $items;
    private $sheetTitle;

    public $buyer;

    public function __construct($data, $sheetTitle = "Спецификация", $buyer = null)
    {
        $this->items = $data ?? [];
        $this->sheetTitle = $sheetTitle;
        $this->buyer = $buyer;

    }

    public function view(): \Illuminate\Contracts\View\View
    {
        $doc = new DocumentLogic();

        return view('export.cart-part2', [
            'items' => $this->items,
            'sheet_title' => $this->sheetTitle,
            'seller' => $doc->getAllSellerParameters(),
            'buyer' => $this->buyer
        ]);
    }

    public function drawings()
    {
        $signStartPos = count($this->items) + 3 + 2 + 13;

        $stampStartPos = $signStartPos+7;

        $drawing1 = new Drawing();
        $drawing1->setName('Подпись');
        $drawing1->setDescription('Первое изображение');
        $drawing1->setPath(public_path('docs/sign_ooo.jpg'));
        $drawing1->setHeight(100);
        $drawing1->setCoordinates("C$signStartPos");

        $drawing2 = new Drawing();
        $drawing2->setName('Печать');
        $drawing2->setDescription('Второе изображение');
        $drawing2->setPath(public_path('docs/stamp_ooo.jpg'));
        $drawing2->setHeight(200);
        $drawing2->setCoordinates("C$stampStartPos");

        return [$drawing1, $drawing2];
    }

    public function registerEvents(): array
    {


        return [
            AfterSheet::class => function (AfterSheet $event) {

                $count = count($this->items) + 3;
                $startPosTable2 = $count + 2;
                $endPosTable2 = $startPosTable2 + 11;

                $sheet = $event->sheet->getDelegate();

                // Устанавливаем внешние границы только для группы ячеек (например, A1:D3)
                $sheet->getStyle("A$startPosTable2:E$endPosTable2")->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("A$startPosTable2:E$endPosTable2")->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("A$startPosTable2:E$endPosTable2")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("A$startPosTable2:E$endPosTable2")->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);

                $sheet->getStyle("F$startPosTable2:I$endPosTable2")->getBorders()->getTop()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("F$startPosTable2:I$endPosTable2")->getBorders()->getRight()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("F$startPosTable2:I$endPosTable2")->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);
                $sheet->getStyle("F$startPosTable2:I$endPosTable2")->getBorders()->getLeft()->setBorderStyle(Border::BORDER_THIN);

               // $sheet->getColumnDimension('B')->setWidth(100); // Ширина колонки B
               // $sheet->getColumnDimension('C')->setWidth(50); // Ширина колонки C

                for ($i = 3; $i < $count; $i++)
                    $sheet->getRowDimension($i)->setRowHeight(150); // Высота строки 1
                // Внутри группы (A2:B2 и т.д.) границ нет, только внешние!
                // Для этого мы не добавляем границы для внутренних ячеек.



                $stampEndPos = $endPosTable2 + 25;
                // Устанавливаем область печати (например, A1:D20)
                $sheet->getPageSetup()->setPrintArea("A1:I$stampEndPos");

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
        $count = count($this->items) + 3;
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
            "A2:I$count" => [ // Укажите диапазон таблицы
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
