<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\IOFactory;

class HandleMultiSheetImport implements WithMultipleSheets
{

    private int $sheetCount;

    public function __construct($filePath)
    {
        $spreadsheet = IOFactory::load($filePath);
        $this->sheetCount = $spreadsheet->getSheetCount();
    }

    public function sheets(): array
    {
        $types = [0, 1];
        $sheets = [];
        for ($i = 0; $i < $this->sheetCount; $i++)
            $sheets[] = new HandlesImport($types[$i] ?? 0);
        return $sheets;
    }
}
