<?php

namespace App\Imports;

use App\Models\Material;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Row;

class PriceImport implements OnEachRow
{


    protected $materials = [];

    public function __construct()
    {

    }

    public function onRow(Row $row)
    {
        $rowIndex = $row->getIndex();
        $row = $row->toArray();

        if ($rowIndex == 1) {
            unset($row[0]);
            unset($row[1]);
            unset($row[2]);
            foreach (array_values($row) as $item)
                if (!is_null($item)) {

                    $this->materials[] = $item;

                    $hasMaterial = count(Material::query()
                            ->where("title", $item)
                            ->get() ?? []) > 0;

                    if (!$hasMaterial)
                        Material::query()->create([
                            "title" => $item
                        ]);

                }
            return null;
        }
        if ($rowIndex <= 2)
            return null;

        if (is_null($row[0] ?? null) || empty($row[0] ?? ''))
            return null;


        $width = (int)filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);// str_replace(" ","",$row[1] ?? 0);
        $height = (int)filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);
        $loopsCount = (int)filter_var($row[2] ?? 0, FILTER_SANITIZE_NUMBER_INT);

        $materialIndex = 0;

        for ($i = 3; $i < count($row); $i += 5) {

            $material = Material::query()->where("title", $this->materials[$materialIndex])->first();

            $price_wholesale = (float)filter_var($row[$i] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_dealer= (float)filter_var($row[$i+1] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_retail= (float)filter_var($row[$i+2] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_cost= (float)filter_var($row[$i+3] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $priceKoef = floatval($row[$i + 4] ?? 0);


            Size::query()->create([
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'material_id' => $material->id,
                'price' => (object)[
                    "wholesale"=>$price_wholesale,
                    "dealer"=>$price_dealer,
                    "retail"=>$price_retail,
                    "cost"=>$price_cost,
                ],
                'price_koef' => $priceKoef,
                'loops_count' => $loopsCount,
            ]);

            $materialIndex++;

            if (count($this->materials) == $materialIndex)
                break;
        }

    }
}
