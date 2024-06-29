<?php

namespace App\Classes;

use App\Models\Color;
use App\Models\Material;
use App\Models\Size;
use Illuminate\Support\Collection;

trait ImportDataTrait
{
    protected $colors = [];
    protected $materials = [];
    protected $depth = [];

    public function importSizeLoopsRow($row, $rowIndex, $type = "sizes", $zeroStart = false)
    {
        if ($rowIndex == $zeroStart ? 0 : 1) {
            unset($row[0]);
            unset($row[1]);
            //dd($row);
            // unset($row[2]);
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
        $materialIndex = 0;

        for ($i = 2; $i < count($row); $i += $type == "sizes" ? 5 : 6) {

            $material = Material::query()->where("title", $this->materials[$materialIndex])->first();

            $stepKoef = 0;

            if ($type == "loops") {
                $stepKoef = 1;
                $value = (int)filter_var($row[$i] ?? 0, FILTER_SANITIZE_NUMBER_INT);
            }

            $price_wholesale = (float)filter_var($row[$i + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_dealer = (float)filter_var($row[$i + 1 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_retail = (float)filter_var($row[$i + 2 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_cost = (float)filter_var($row[$i + 3 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $priceKoef = floatval($row[$i + 4 + $stepKoef] ?? 0);

            $s = Size::query()->create([
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'material_id' => $material->id,
                'price' => (object)[
                    "wholesale" => $price_wholesale,
                    "dealer" => $price_dealer,
                    "retail" => $price_retail,
                    "cost" => $price_cost,
                ],
                'price_koef' => $priceKoef,
                "type" => $type,
                'value' => $value ?? 0,
            ]);

            $materialIndex++;


            if (count($this->materials)==$materialIndex)
                break;
            ;
        }

    }

    public function importColorsRow($row, $rowIndex,$zeroStart = false)
    {
        $colors = ["Black" => "#000", "Silver" => "#111", "Gold" => "#f10", "RAL" => null];
        if ($rowIndex ==  $zeroStart ? 0 : 1) {
            unset($row[0]);
            unset($row[1]);
            //unset($row[2]);
            foreach (array_values($row) as $item)
                if (!is_null($item)) {

                    $pattern = "/.*(Silver|Gold|RAL|Black).*/i";

                    $matches = [];
                    $colorVal = preg_match($pattern, $item, $matches);

                    if (!$colorVal)
                        continue;


                    $this->colors[] = $matches[1];

                    /*
                                        $hasMaterial = count(Material::query()
                                                ->where("title", $item)
                                                ->get() ?? []) > 0;

                                        if (!$hasMaterial)
                                            Material::query()->create([
                                                "title" => $item
                                            ]);*/

                }

            return null;
        }
        if ($rowIndex <=  2)
            return null;


        if (is_null($row[0] ?? null) || empty($row[0] ?? ''))
            return null;


        $width = (int)filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);// str_replace(" ","",$row[1] ?? 0);
        $height = (int)filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);


        $colorIndex = 0;

        for ($i = 2; $i < count($row); $i += 5) {

            // $material = Material::query()->where("title", $this->materials[$materialIndex])->first();

            $stepKoef = 0;

            $price_wholesale = (float)filter_var($row[$i + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_dealer = (float)filter_var($row[$i + 1 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_retail = (float)filter_var($row[$i + 2 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_cost = (float)filter_var($row[$i + 3 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $priceKoef = floatval($row[$i + 4 + $stepKoef] ?? 0);

            $res = Size::query()->create([
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'material_id' => null,
                'price' => (object)[
                    "wholesale" => $price_wholesale,
                    "dealer" => $price_dealer,
                    "retail" => $price_retail,
                    "cost" => $price_cost,
                ],
                'price_koef' => $priceKoef,
                "type" => "colors",
                'value' => $this->colors[$colorIndex] ?? '-',
            ]);


            $title = $this->colors[$colorIndex];

            $code = $colors[$title] ?? null;


            $isExist = !is_null(Color::query()->where("title", $title)
                ->first() ?? null);

            if (!$isExist) {
                Color::query()
                    ->create([
                        'title' => $title,
                        'order_position' => 0,
                        'price' => (object)[
                            "wholesale" => 0,
                            "dealer" => 0,
                            "retail" => 0,
                            "cost" => 0,
                        ],
                        'type' => "all",
                        'code' =>$code,
                        'assign_with_size' => true,
                    ]);
            }

            $colorIndex++;
            /*  $materialIndex++;


              if (count($this->depth) == $materialIndex)
                  break;*/
        }

    }

    public function importDepthRow($row, $rowIndex,$zeroStart = false)
    {

        if ($rowIndex == $zeroStart ? 0 : 1) {
            unset($row[0]);
            unset($row[1]);
            //unset($row[2]);


            foreach (array_values($row) as $item)
                if (!is_null($item)) {

                    $pattern = "/.*([0-9]{2}).*/i";

                    $matches=[];
                    $depthVal = preg_match($pattern,$item, $matches);

                    if (!$depthVal)
                        continue;

                    $this->depth[] = $matches[1];

                    /*
                                        $hasMaterial = count(Material::query()
                                                ->where("title", $item)
                                                ->get() ?? []) > 0;

                                        if (!$hasMaterial)
                                            Material::query()->create([
                                                "title" => $item
                                            ]);*/

                }


            return null;
        }
        if ($rowIndex <= 2)
        {
            return null;
        }


        if (is_null($row[0] ?? null) || empty($row[0] ?? ''))
            return null;


        $width = (int)filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);// str_replace(" ","",$row[1] ?? 0);
        $height = (int)filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);


        $depthIndex = 0;

        for ($i = 2; $i < count($row); $i += 5 ) {

            // $material = Material::query()->where("title", $this->materials[$materialIndex])->first();

            $stepKoef = 0;

            $price_wholesale = (float)filter_var($row[$i + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_dealer = (float)filter_var($row[$i + 1 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_retail = (float)filter_var($row[$i + 2 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $price_cost = (float)filter_var($row[$i + 3 + $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
            $priceKoef = floatval($row[$i + 4 + $stepKoef] ?? 0);

            $res = Size::query()->create([
                'width' => $width ?? 0,
                'height' => $height ?? 0,
                'material_id' => null,
                'price' => (object)[
                    "wholesale" => $price_wholesale,
                    "dealer" => $price_dealer,
                    "retail" => $price_retail,
                    "cost" => $price_cost,
                ],
                'price_koef' => $priceKoef,
                "type" => "depth",
                'value' => $this->depth[$depthIndex] ?? '-',
            ]);

            $depthIndex++;


            /*  $materialIndex++;

              if (count($this->depth) == $materialIndex)
                  break;*/
        }

    }

    public function importRecountPrice(){
        ini_set('max_execution_time', '3000');



            // $materials = Material::query()->get();

            // foreach ($materials as $material) {
            $sizes = Size::query()
                ->get();

            $consumeBasePrice = [];

            $pricesKoefItems = Collection::make($sizes->toArray())
                ->where("price_koef", 1)
                ->all();

            foreach ($pricesKoefItems as $priceKoefItem)
                $consumeBasePrice[$priceKoefItem["width"]][$priceKoefItem["material_id"] ?? $priceKoefItem["type"]] = $priceKoefItem["price"];

            foreach ($sizes as $size) {

                if (!isset($consumeBasePrice[$size->width][$size->material_id??$size->type])) {
                    continue;
                }

                $size->price = (object)[
                    "wholesale" => $consumeBasePrice[$size->width][$size->material_id??$size->type]["wholesale"] * ($size->price_koef ?? 1),
                    "dealer" => $consumeBasePrice[$size->width][$size->material_id??$size->type]["dealer"] * ($size->price_koef ?? 1),
                    "retail" => $consumeBasePrice[$size->width][$size->material_id??$size->type]["retail"] * ($size->price_koef ?? 1),
                    "cost" => $consumeBasePrice[$size->width][$size->material_id??$size->type]["cost"] * ($size->price_koef ?? 1),
                ];


                $size->save();
            }

    }
}
