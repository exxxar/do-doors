<?php

namespace App\Imports;

use App\Classes\ImportDataTrait;
use App\Models\Color;
use App\Models\Material;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;

class PriceColorsImport implements OnEachRow
{
    use ImportDataTrait;

    public function __construct()
    {
        $colors = Color::query()->get();

        foreach ($colors as $color)
        {
            $color->deleted_at = Carbon::now();
            $color->save();
        }
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        return $this->importColorsRow($row, $rowIndex);
    }
}
