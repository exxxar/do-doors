<?php

namespace App\Http\Controllers;

use App\Exports\PriceExport;
use App\Exports\PriceV2Export;
use App\Http\Requests\SizeStoreRequest;
use App\Http\Requests\SizeUpdateRequest;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Http\Resources\SizeCollection;
use App\Http\Resources\SizeResource;
use App\Imports\PriceImport;
use App\Models\Handle;
use App\Models\Material;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class SizeController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/SizesPage');
    }

    public function getPreparedPrices(Request $request)
    {
        $heightList = array_values(Size::query()
            ->distinct()
            ->pluck("height")->toArray());

        $widthList = array_values(Size::query()
            ->distinct()
            ->pluck("width")->toArray());

        $sizes = Size::query()
            ->get()
            ->sortBy([
                ['height', 'asc'],
                ['width', 'asc'],
            ]);

        $tmp = [];

        foreach ($heightList as $height) {
            foreach ($widthList as $width) {
                $materialList = Collection::make($sizes)
                    ->where("width", $width)
                    ->where("height", $height)
                    ->unique("material_id")
                    ->toArray();

                $tmpMaterials = [];
                foreach ($materialList as $material) {
                    $material = (object)$material;
                    $tmpMaterials[] = (object)[
                        "id" => $material->id ?? null,
                        "price" => $material->price ?? 0,
                        "price_koef" => $material->price_koef ?? 0,
                        "width" => $material->width,
                        "height" => $material->height,
                        "material_id" => $material->material_id,
                    ];
                }

                $tmp[] = (object)[
                    "width" => $width,
                    "height" => $height,
                    "prices" => $tmpMaterials
                ];
            }
        }

        $materials = Material::query()->select("title", "id")->get()->toArray();

        /* foreach ($tmp as $item)
             if (count($item->prices)<count($materials))
             {
                 for ($i=0;$i<count($materials)-count($item->prices);$i++)
                     $item->prices[] = (object)[
                         "id" =>  null,
                         "price" =>  0,
                         "price_koef" =>  0,
                         "width" => $item->width,
                         "height" => $item->height,
                         "material_id" => $materials[count($materials)-1]["id"],
                     ];
             }*/
        //if (count($materials)<)
        return response()->json([
            "materials" => $materials,
            "prices" => $tmp
        ]);
    }


    public function exportPrices(Request $request)
    {
        $heightList = array_values(Size::query()
            ->distinct()
            ->pluck("height")->toArray());

        $widthList = array_values(Size::query()
            ->distinct()
            ->pluck("width")->toArray());

        $sizes = Size::query()
            ->get()
            ->sortBy([
                ['height', 'asc'],
                ['width', 'asc'],
            ]);

        $tmp = [];

        foreach ($heightList as $height) {
            foreach ($widthList as $width) {
                $materialList = Collection::make($sizes)
                    ->where("width", $width)
                    ->where("height", $height)
                    ->unique("material_id")
                    ->toArray();

                $tmpMaterials = [];
                foreach ($materialList as $material) {
                    $material = (object)$material;
                    $tmpMaterials[] = (object)[
                        "id" => $material->id,
                        "price" => $material->price,
                        "price_koef" => $material->price_koef,
                        "material_id" => $material->material_id,
                    ];
                }

               // Log::info("loop=>".print_r(array_values($materialList), true));
                $tmp[] = (object)[
                    "width" => $width,
                    "height" => $height,
                    "loops_count" => array_values($materialList)[0]["loops_count"] ?? 0,
                    "prices" => $tmpMaterials
                ];
            }
        }
        $materials = Material::query()->select("title", "id")->get()->toArray();
        /*

         foreach ($tmp as $item)
             if (count($item->prices)<count($materials))
             {
                 for ($i=0;$i<((count($materials)-count($item->prices))+1);$i++)
                     $item->prices[] = (object)[
                         "id" =>  null,
                         "price" =>  0,
                         "price_koef" =>  0,

                     ];
             }*/


        return Excel::download(new PriceV2Export([
            "materials" => $materials,
            "prices" => $tmp
        ]), 'invoices.xlsx');

    }

    public function getFormatted()
    {

        $sizes = Size::query()
            ->get();

        $tmp = [];

        foreach ($sizes as $size) {
            if (empty($tmp)) {
                $tmp[] = (object)[
                    "id" => $size->id,
                    "width" => $size->width,
                    "height" => $size->height,
                    "loops_count" => $size->loops_count,
                    "materials" => [
                        (object)[
                            "id" => $size->material->id,
                            "title" => $size->material->title,
                            "price" => $size->price ?? 0,
                        ]
                    ],
                ];
            } else {
                $sub = array_filter($tmp, function ($item) use ($size) {
                    return $item->width == $size->width && $item->height == $size->height;
                });

                if (empty($sub))
                    $tmp[] = (object)[
                        "id" => $size->id,
                        "width" => $size->width,
                        "height" => $size->height,
                        "loops_count" => $size->loops_count,
                        "materials" => [
                            (object)[
                                "id" => $size->material->id,
                                "title" => $size->material->title,
                                "price" => $size->price ?? 0,
                            ]
                        ],
                    ];

                foreach ($tmp as $item) {
                    if ($item->width == $size->width && $item->height == $size->height) {
                        $subMaterial = array_filter($item->materials, function ($item) use ($size) {
                            return $item->id == $size->material->id;
                        });

                        if (empty($subMaterial))
                            $item->materials[] = (object)[
                                "id" => $size->material->id,
                                "title" => $size->material->title,
                                "price" => $size->price ?? 0,
                            ];
                    }

                }
            }
        }

        file_put_contents(public_path() . '\sizes.json', json_encode([
            "prices" => $tmp,
            "materials" => Material::query()->get(),
            "handles" => Handle::query()->get()
        ]));

    }

    public function duplicate(Request $request, $id)
    {
        $size = Size::query()->find($id);

        if (is_null($size))
            return response()->noContent(404);

        $tmp = $size->replicate();
        $tmp->save();

        return response()->noContent();
    }

    public function generateSizes(Request $request)
    {

        $request->validate([
            "material_id" => "required",
            /* "base_width" => "required",
             "base_height" => "required",
             "base_koef" => "required",
             "base_loops" => "required",
             "base_price" => "required",
             "width_step" => "required",
             "height_step" => "required",
             "koef_step" => "required",
             "loops_step" => "required",
             "price_step" => "required",*/
            "steps" => "required",

        ]);

        $material_id = $request->material_id ?? null;

        $baseWidth = $request->base_width ?? 0;
        $baseHeight = $request->base_height ?? 0;
        $baseKoef = $request->base_koef ?? 0;
        $baseLoops = $request->base_loops ?? 0;
        $basePrice = $request->base_price ?? 0;

        $stepWidth = $request->width_step ?? 0;
        $stepHeight = $request->height_step ?? 0;
        $stepKoef = $request->koef_step ?? 0;
        $stepLoops = $request->loops_step ?? 0;
        $stepPrice = $request->price_step ?? 0;

        $steps = $request->steps ?? 0;

        for ($i = 0; $i < $steps; $i++) {

            $baseWidth += $stepWidth;
            $baseHeight = $stepHeight;
            $baseKoef += $stepKoef;
            $baseLoops += $stepLoops;
            $basePrice += $stepPrice;

            $isUniq = is_null(Size::query()
                ->where("width", $request->width)
                ->where("height", $request->height)
                ->where("material_id", $material_id)
                ->first());

            if ($isUniq)
                Size::query()->create([
                    'width' => $baseWidth,
                    'height' => $baseHeight,
                    'material_id' => $material_id,
                    'price' => $basePrice,
                    'price_koef' => $baseKoef,
                    'loops_count' => $baseLoops,
                ]);
        }


        return response()->noContent();
    }

    public function recountPrice(Request $request)
    {

        $request->validate([
            "material_id" => "required",
            "recount_price" => "required"
        ]);

        $material_id = $request->material_id ?? null;
        $needRecountByWidth = ($request->need_recount_by_width ?? false) == "true";
        $needRecountByHeight = ($request->need_recount_by_height ?? false) == "true";
        $width = $request->base_width ?? null;
        $height = $request->base_height ?? null;
        $price = $request->recount_price ?? 0;

        $sizes = Size::query()
            ->where("material_id", $material_id);


        if ($needRecountByWidth)
            $sizes = $sizes->where("width", intval($width));

        if ($needRecountByHeight)
            $sizes = $sizes->where("height", $height);

        $sizes = $sizes->get();

        $changeCount = 0;
        foreach ($sizes as $size) {
            $size->price = $price * ($size->price_koef ?? 1);
            $size->save();

            $changeCount++;
        }

        return response()->json([
            "affected" => $changeCount
        ]);
    }

    public function getSizeList(Request $request): SizeCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $sizes = Size::query();

        if (!is_null($search))
            $sizes = $sizes
                ->where("width", 'like', "%$search%")
                ->orWhere("height", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%")
                ->orWhereHas("material", function ($q) use ($search) {
                    $q->where("title", 'like', "%$search%");
                });

        $sizes = $sizes->orderBy($order, $direction);

        return new SizeCollection($sizes->paginate($size));
    }

    public function updateParam(Request $request): \Illuminate\Http\Response|SizeResource
    {
        $request->validate([
            'key' => "required",
            'value' => "required",
        ]);

        if (is_null($request->id ?? null)) {
            $size = Size::query()->create([
                'width' => $request->width,
                'height' => $request->height,
                'material_id' => $request->material_id,
                'price' => 0,
                'price_koef' => 0,
                'loops_count' => 0,
            ]);

            $size[$request->key] = $request->value ?? $size[$request->key];
            $size->save();
            return new SizeResource($size);
        }

        $size = Size::query()
            ->where("id", $request->id)
            ->first();

        if (is_null($size))
            return response()->noContent(400);

        $size[$request->key] = $request->value ?? $size[$request->key];

        $size->save();

        return new SizeResource($size);

    }

    public function import(Request $request)
    {
        $needRewrite = ($request->need_rewrite ?? false) == "true";

        $tmp = $this->uploadDocuments(
            $request->hasFile('files') ?
                $request->file('files') : null);

        if ($needRewrite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('sizes')->truncate();
        }

        foreach ($tmp as $file)
            Excel::import(new PriceImport, storage_path("app/public/documents/" . $file));


        return response()->noContent();
    }

    public function store(Request $request)
    {
        $request->validate([
            'width' => "required",
            'height' => "required",
            'material_id' => "required",
        ]);

        $id = $request->id ?? null;

        $material = Material::query()->find($request->material_id ?? null);

        if (is_null($material))
            return response()->noContent(404);

        $priceData = json_decode($request->price ?? '[]');

        if (is_null($id)) {

            $isUniq = is_null(Size::query()
                ->where("width", $request->width)
                ->where("height", $request->height)
                ->where("material_id", $material->id)
                ->first());

            if (!$isUniq)
                return response()->noContent(400);


            $size = Size::query()
                ->create([
                    'width' => $request->width ?? 0,
                    'height' => $request->height ?? 0,
                    'material_id' => $material->id,
                    'price' => (object)[
                        "wholesale" => $priceData->wholesale ?? 0,
                        "dealer" => $priceData->dealer ?? 0,
                        "retail" => $priceData->retail ?? 0,
                        "cost" => $priceData->cost ?? 0,
                    ],
                    'price_koef' => $request->price_koef ?? 0,
                    'loops_count' => $request->loops_count ?? 0,
                ]);
        } else {
            $size = Size::query()->find($id);

            if (is_null($size))
                return response()->noContent(404);

            $size->update([
                'width' => $request->width ?? 0,
                'height' => $request->height ?? 0,
                'material_id' => $material->id,
                'price' => (object)[
                    "wholesale" => $priceData->wholesale ?? 0,
                    "dealer" => $priceData->dealer ?? 0,
                    "retail" => $priceData->retail ?? 0,
                    "cost" => $priceData->cost ?? 0,
                ],
                'price_koef' => $request->price_koef ?? 0,
                'loops_count' => $request->loops_count ?? 0,
            ]);

        }

        return new SizeResource($size);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $size = Size::query()->find($id);

        if (is_null($size))
            return response()->noContent(404);

        $size->delete();

        return response()->noContent(200);
    }
}
