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

class PriceSizeLoopsImport implements OnEachRow
{
    use ImportDataTrait;

    protected $type = "sizes";

    public function __construct($type = "sizes")
    {
        $this->type = $type;

    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        return $this->importSizeLoopsRow($row, $rowIndex, $this->type);
    }
}
