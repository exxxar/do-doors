<?php

namespace App\Classes;

use App\Models\Color;
use App\Models\Material;
use App\Models\Size;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

trait ImportDataTrait
{
    protected $colors = [];
    protected $materials = [];
    protected $depth = [];

    public function importSizeLoopsRow($row, $rowIndex, $type = "sizes", $zeroStart = false)
    {
        if ($rowIndex == ($zeroStart ? 0 : 1)) {
            unset($row[0]);
            unset($row[1]);

            // unset($row[2]);
            foreach (array_values($row) as $item)
                if (!is_null($item ?? null) && !empty($item ?? "")) {

                    $this->materials[] = $item;

                    $tmpMaterial = Material::withTrashed()
                        ->where("title", $item)
                        ->first();

                    $hasMaterial = !is_null($tmpMaterial ?? null);

                    if (!$hasMaterial)
                        Material::query()->create([
                            "title" => $item,
                            "is_base" => trim(mb_strtolower($item)) == "под покраску"
                        ]);
                    else {
                        $tmpMaterial->deleted_at = null;
                        $tmpMaterial->save();
                    }

                    //Log::info("material=>$item =>".(trim(mb_strtolower($item)) == "под покраску"?"true":"false"));
                }


            return null;
        }


        if ($rowIndex <= ($zeroStart ? 1 : 2))
            return null;


        if (is_null($row[0] ?? null) || empty($row[0] ?? ''))
            return null;


        $width = (int)filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);// str_replace(" ","",$row[1] ?? 0);
        $height = (int)filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);
        $materialIndex = 0;

        for ($i = 2; $i < count($row); $i += $type == "sizes" ? 5 : 6) {

            if ($materialIndex == count($this->materials))
                break;

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


            if (count($this->materials) == $materialIndex)
                break;;
        }

    }

    public function importColorsRow($row, $rowIndex, $zeroStart = false)
    {
        $colors = ["Black" => "#000000", "Silver" => "#c0c0c0", "Gold" => "#ffd700", "RAL" => null];
        if ($rowIndex == ($zeroStart ? 0 : 1)) {
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
        if ($rowIndex <= ($zeroStart ? 1 : 2))
            return null;


        if (is_null($row[0] ?? null) || empty($row[0] ?? ''))
            return null;


        $width = (int)filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);// str_replace(" ","",$row[1] ?? 0);
        $height = (int)filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);


        $colorIndex = 0;

        for ($i = 2; $i < count($row); $i += 5) {

            if ($colorIndex == count($this->colors))
                break;
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


            $tmpColor = Color::withTrashed()->where("title", $title)
                ->first() ;

            $isExist = !is_null($tmpColor ?? null);

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
                        'code' => $code,
                        'assign_with_size' => true,
                    ]);
            }
            else {
                $tmpColor->deleted_at = null;
                $tmpColor->save();
            }

            $colorIndex++;
            /*  $materialIndex++;


              if (count($this->depth) == $materialIndex)
                  break;*/
        }

    }

    public function importDepthRow($row, $rowIndex, $zeroStart = false)
    {

        if ($rowIndex == ($zeroStart ? 0 : 1)) {
            unset($row[0]);
            unset($row[1]);
            //unset($row[2]);


            foreach (array_values($row) as $item)
                if (!is_null($item)) {

                    $pattern = "/.*([0-9]{2}).*/i";

                    $matches = [];
                    $depthVal = preg_match($pattern, $item, $matches);

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
        if ($rowIndex <= ($zeroStart ? 1 : 2)) {
            return null;
        }


        if (is_null($row[0] ?? null) || empty($row[0] ?? ''))
            return null;


        $width = (int)filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);// str_replace(" ","",$row[1] ?? 0);
        $height = (int)filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);


        $depthIndex = 0;

        for ($i = 2; $i < count($row); $i += 5) {

            if ($depthIndex == count($this->depth))
                break;
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

    public function importRecountPrice()
    {
        ini_set('max_execution_time', '3000');

        $minHeight = Size::query()
            ->where("type", "sizes")
            ->min("height");

        $uniqWidth = Size::query()
            ->where("type", "sizes")
            ->get()->unique("width");


        // $materials = Material::query()->get();

        // foreach ($materials as $material) {
        $sizes = Size::query()
            //->where("type","sizes")
            //    ->whereIn("width",array_values($uniqWidth->pluck("width")->toArray()))
            //   ->where("height", $minHeight)
            ->get();

        $consumeBasePrice = [];

        $pricesKoefItems = Size::query()
            //  ->where("type","sizes")
            ->whereIn("width", array_values($uniqWidth->pluck("width")->toArray()))
            ->where("height", $minHeight)
            ->where("price_koef", 1)
            ->get();

        foreach ($pricesKoefItems as $priceKoefItem)
            $consumeBasePrice[$priceKoefItem["width"]][$priceKoefItem["material_id"] ?? $priceKoefItem["type"]] = $priceKoefItem["price"] ?? [
                "wholesale" => 0,
                "dealer" => 0,
                "retail" => 0,
                "cost" => 0,
            ];

        function intRound($arg): float|int
        {
            return round(intval($arg) / 10) * 10;
        }

        foreach ($sizes as $size) {

            if (!isset($consumeBasePrice[$size->width][$size->material_id ?? $size->type])) {
                continue;
            }


            $size->price = (object)[
                "wholesale" => intRound(round($consumeBasePrice[$size->width][$size->material_id ?? $size->type]["wholesale"] * ($size->price_koef ?? 1))),
                "dealer" => intRound(round($consumeBasePrice[$size->width][$size->material_id ?? $size->type]["dealer"] * ($size->price_koef ?? 1))),
                "retail" => intRound(round($consumeBasePrice[$size->width][$size->material_id ?? $size->type]["retail"] * ($size->price_koef ?? 1))),
                "cost" => intRound(round($consumeBasePrice[$size->width][$size->material_id ?? $size->type]["cost"] * ($size->price_koef ?? 1))),
            ];



            $size->save();
        }

    }
}
