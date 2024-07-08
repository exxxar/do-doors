<?php

namespace App\Imports;

use App\Classes\ImportDataTrait;
use App\Models\Material;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;

class PriceDepthImport implements OnEachRow
{
    use ImportDataTrait;

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        return $this->importDepthRow($row, $rowIndex);
    }
}
