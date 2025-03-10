<?php

namespace App\Imports;

use App\Classes\ImportDataTrait;
use App\Models\Color;
use App\Models\Handle;
use App\Models\Material;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;

class HandlesImport implements OnEachRow
{


    private int $type;

    public function __construct($type = 0)
    {
        $this->type = $type;
    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();


        return $this->import($row, $rowIndex);
    }

    private function import($row, $rowIndex)
    {

        if ($rowIndex <= ($this->type == 0 ? 2 : 1) || empty($row[0])) {
            return null;
        }


        $title = null;
        $order_position = null;
        $color = null;
        $sku = null;
        $comment = null;
        $brand = null;
        $weight = 0;
        $material = null;
        $material_description = null;
        $coverage = null;
        $serial = null;
        $model = null;
        $characteristics = null;
        $base_shape = null;
        $socket_diameter = 0;
        $square_length = null;
        $guarantee = null;
        $dimensions = null;

        $variants = [];

        if ($this->type == 0) {
            $weight = (int)filter_var($row[5] ?? 0, FILTER_SANITIZE_NUMBER_INT);

            $title = $row[1] ?? '-';
            $order_position = 0;


            $sku = $row[0] ?? null;
            $comment = $row[23] ?? null;
            $brand = $row[4] ?? null;
            $weight = $weight ?? null;
            $material = $row[8] ?? null;
            $material_description = $row[9] ?? null;
            $coverage = $row[10] ?? null;
            $serial = $row[21] ?? null;
            $model = $row[22] ?? null;
            $characteristics = $row[6] ?? null;

            $color = $row[7] ?? $characteristics ?? null;

            $base_shape = $row[11] ?? null;
            $socket_diameter = floatval($row[12] ?? 0);
            $square_length = $row[13] ?? null;
            $guarantee = $row[14] ?? null;
            $dimensions = $row[19] ?? null;

            $price_retail = str_replace(',', '.', $row[2] ?? 0);
            $price_retail = (float)filter_var($price_retail, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            $price_wholesale = str_replace(',', '.', $row[3] ?? 0);
            $price_wholesale = (float)filter_var($price_wholesale, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


            for ($i = 15; $i <= 17; $i++)
                if (!is_null($row[$i] ?? null))
                    $variants[] = (object)[
                        "image" => $row[$i],
                        "title" => null,
                        "description" => null,
                    ];
        }

        if ($this->type == 1) {
            $weight = (int)filter_var($row[5] ?? 0, FILTER_SANITIZE_NUMBER_INT);

            $title = $row[1] ?? '-';
            $order_position = 0;

            $sku = $row[0] ?? null;
            $brand = $row[4] ?? null;
            $weight = $weight ?? null;
            $serial = $row[14] ?? null;
            $model = $row[15] ?? null;
            $characteristics = $row[6] ?? null;

            $color = $row[7] ?? $characteristics ?? null;
            $guarantee = $row[7] ?? null;

            $dimensions = $row[12] ?? null;

            $price_retail = str_replace(',', '.', $row[2] ?? 0);
            $price_retail = (float)filter_var($price_retail, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            $price_wholesale = str_replace(',', '.', $row[3] ?? 0);
            $price_wholesale = (float)filter_var($price_wholesale, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);


            for ($i = 8; $i <= 11; $i++)
                if (!is_null($row[$i] ?? null))
                    $variants[] = (object)[
                        "image" => $row[$i],
                        "title" => null,
                        "description" => null,
                    ];


        }


        $price = (object)[
            "wholesale" => $price_wholesale == 0 ? $price_retail : $price_wholesale,
            "dealer" => $price_wholesale== 0 ? $price_retail : $price_wholesale,
            "retail" => $price_retail== 0 ?  $price_wholesale : $price_retail,
            "cost" => $price_wholesale== 0 ? $price_retail : $price_wholesale,
        ];


        $handle = Handle::query()->create([
            'title' => $title,
            'order_position' => $order_position,
            'color' => $color,
            'price' => $price,
            'variants' => $variants,
            'sku' => $sku,
            'comment' => $comment,
            'brand' => $brand,
            'weight' => $weight,
            'material' => $material,
            'material_description' => $material_description,
            'coverage' => $coverage,
            'serial' => $serial,
            'model' => $model,
            'characteristics' => $characteristics,
            'base_shape' => $base_shape,
            'socket_diameter' => $socket_diameter,
            'square_length' => $square_length,
            'guarantee' => $guarantee,
            'dimensions' => $dimensions,
        ]);

    }

}
