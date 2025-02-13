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
            $row = array_slice($row, 2); // Удаляем первые два элемента без потери индексов

            foreach ($row as $item) {
                if (!empty($item)) {
                    $this->materials[] = $item;

                    $material = Material::withTrashed()->firstOrCreate(
                        ["title" => $item],
                        ["is_base" => mb_strtolower(trim($item)) == "под покраску"]
                    );

                    $material->restore(); // Восстанавливаем, если было удалено
                }
            }

            return null;
        }

        if ($rowIndex <= ($zeroStart ? 1 : 2) || empty($row[0])) {
            return null;
        }

        $width = (int) filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);
        $height = (int) filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);

        $materialIndex = 0;

        for ($i = 2; $i < count($row) && $materialIndex < count($this->materials); $i += ($type == "sizes" ? 5 : 6)) {
            $material = Material::where("title", $this->materials[$materialIndex])->first();

            $stepKoef = ($type == "loops") ? 1 : 0;

            $price_wholesale = (float)filter_var($row[$i+ $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $price_dealer = (float)filter_var($row[$i + 1+ $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $price_retail = (float)filter_var($row[$i + 2+ $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $price_cost = (float)filter_var($row[$i + 3+ $stepKoef] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $priceKoef = floatval($row[$i + 4+ $stepKoef] ?? 0);

            Size::create([
                'width' => $width,
                'height' => $height,
                'material_id' => $material->id ?? null,
                'price' => (object) [
                    "wholesale" => $price_wholesale,
                    "dealer" => $price_dealer,
                    "retail" =>$price_retail,
                    "cost" => $price_cost,
                ],
                'price_koef' => $priceKoef,
                "type" => $type,
                'value' => $type == "loops" ? (int) ($row[$i] ?? 0) : 0,
            ]);

            $materialIndex++;
        }
    }

    public function importColorsRow($row, $rowIndex, $zeroStart = false)
    {
        $colorMap = ["Black" => "#000000", "Silver" => "#c0c0c0", "Gold" => "#ffd700", "RAL" => null];

        if ($rowIndex == ($zeroStart ? 0 : 1)) {
            $row = array_slice($row, 2);

            foreach ($row as $item) {
                if (preg_match("/(Silver|Gold|RAL|Black)/i", $item, $matches)) {
                    $this->colors[] = $matches[1];
                }
            }

            return null;
        }

        if ($rowIndex <= ($zeroStart ? 1 : 2) || empty($row[0])) {
            return null;
        }

        $width = (int) filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);
        $height = (int) filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);

        foreach ($this->colors as $index => $color) {
            $i = 2 + $index * 5;

            $price_wholesale = (float)filter_var($row[$i] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $price_dealer = (float)filter_var($row[$i + 1] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $price_retail = (float)filter_var($row[$i + 2] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $price_cost = (float)filter_var($row[$i + 3] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $priceKoef = floatval($row[$i + 4] ?? 0);

            Size::create([
                'width' => $width,
                'height' => $height,
                'material_id' => null,
                'price' => (object) [
                    "wholesale" => $price_wholesale,
                    "dealer" => $price_dealer,
                    "retail" =>$price_retail,
                    "cost" => $price_cost,
                ],
                'price_koef' => $priceKoef,
                "type" => "colors",
                'value' => $color,
            ]);

            Color::withTrashed()->firstOrCreate(
                ['title' => $color],
                ['code' => $colorMap[$color] ?? null, 'assign_with_size' => true]
            )->restore();
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
            $rawValue_wholesale  = str_replace(',', '.', $row[$i + $stepKoef] ?? 0);
            $rawValue_dealer   = str_replace(',', '.', $row[$i + 1 + $stepKoef] ?? 0);
            $rawValue_retail   = str_replace(',', '.', $row[$i + 2 + $stepKoef] ?? 0);
            $rawValue_cost   = str_replace(',', '.', $row[$i + 3 + $stepKoef] ?? 0);

            $price_wholesale = (float)filter_var($rawValue_wholesale, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $price_dealer = (float)filter_var($rawValue_dealer, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $price_retail = (float)filter_var($rawValue_retail, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $price_cost = (float)filter_var($rawValue_cost, FILTER_SANITIZE_NUMBER_FLOAT,FILTER_FLAG_ALLOW_FRACTION);
            $priceKoef = floatval($row[$i + 4 + $stepKoef] ?? 0);

            Log::info("depth=>".print_r([
                    "row"=>$row,
                    "wholesale" => $price_wholesale,
                    "dealer" => $price_dealer,
                    "retail" => $price_retail,
                    "cost" => $price_cost,
                ],true));

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
