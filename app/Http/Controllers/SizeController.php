<?php

namespace App\Http\Controllers;

use App\Classes\ImportDataTrait;
use App\Exports\PriceExport;
use App\Exports\PriceV2Export;
use App\Exports\PriceV3Export;
use App\Http\Requests\SizeStoreRequest;
use App\Http\Requests\SizeUpdateRequest;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Http\Resources\SizeCollection;
use App\Http\Resources\SizeResource;
use App\Imports\PriceSizeLoopsImport;
use App\Imports\PriceMultiSheetImport;
use App\Models\Color;
use App\Models\DoorVariant;
use App\Models\Handle;
use App\Models\Hinge;
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
    use Utility, ImportDataTrait;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/SizesPage');
    }

    protected function preparePrices(): array
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

        //  dd(Size::query()->where("material_id",11)->get());

        $tmpSizes = [];
///
        foreach ($heightList as $height) {
            foreach ($widthList as $width) {
                $materialList = Collection::make($sizes)
                    ->where("width", $width)
                    ->where("height", $height)
                    ->where("type", "sizes")
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
                $tmpSizes[] = (object)[
                    "width" => $width,
                    "height" => $height,
                    "prices" => $tmpMaterials
                ];


            }
        }

        $tmpLoops = [];
///->where("type","sizes")
        foreach ($heightList as $height) {
            foreach ($widthList as $width) {
                $materialList = Collection::make($sizes)
                    ->where("width", $width)
                    ->where("height", $height)
                    ->where("type", "loops")
                    ->unique("material_id")
                    ->toArray();


                $tmpMaterials = [];
                foreach ($materialList as $material) {
                    $material = (object)$material;
                    $tmpMaterials[] = (object)[
                        "id" => $material->id,
                        "price" => $material->price,
                        "price_koef" => $material->price_koef,
                        "value" => $material->value,
                        "material_id" => $material->material_id,
                    ];
                }

                // Log::info("loop=>".print_r(array_values($materialList), true));
                $tmpLoops[] = (object)[
                    "width" => $width,
                    "height" => $height,

                    "prices" => $tmpMaterials
                ];


            }
        }

        $tmpColors = [];
///->where("type","sizes")
        foreach ($heightList as $height) {
            foreach ($widthList as $width) {
                $materialList = Collection::make($sizes)
                    ->where("width", $width)
                    ->where("height", $height)
                    ->where("type", "colors")
                    ->unique("value")
                    ->toArray();


                $tmpValues = [];
                foreach ($materialList as $val) {
                    $val = (object)$val;
                    $tmpValues[] = (object)[
                        "id" => $val->id,
                        "price" => $val->price,
                        "price_koef" => $val->price_koef,
                        "value" => $val->value,
                    ];
                }

                // Log::info("loop=>".print_r(array_values($materialList), true));
                $tmpColors[] = (object)[
                    "width" => $width,
                    "height" => $height,

                    "prices" => $tmpValues
                ];


            }
        }


        $tmpDepth = [];
///->where("type","sizes")
        foreach ($heightList as $height) {
            foreach ($widthList as $width) {
                $materialList = Collection::make($sizes)
                    ->where("width", $width)
                    ->where("height", $height)
                    ->where("type", "depth")
                    ->unique("value")
                    ->toArray();


                $tmpValues = [];
                foreach ($materialList as $val) {
                    $val = (object)$val;
                    $tmpValues[] = (object)[
                        "id" => $val->id,
                        "price" => $val->price,
                        "price_koef" => $val->price_koef,
                        "value" => $val->value,
                    ];
                }

                // Log::info("loop=>".print_r(array_values($materialList), true));
                $tmpDepth[] = (object)[
                    "width" => $width,
                    "height" => $height,

                    "prices" => $tmpValues
                ];


            }
        }


        $materials = Material::query()->select("title", "id")->get()->toArray();
        $variants = Size::query()->where("type", "depth")->get()->unique("value")->toArray();
        $colors = Size::query()->where("type", "colors")->get()->unique("value")->toArray();

        $tmpDepthNames = [];

        foreach ($variants as $variant) {
            $variant = (object)$variant;
            $tmpDepthNames[] = (object)[
                "title" => "толщина $variant->value мм"
            ];
        }


        $tmpColorsNames = [];

        foreach ($colors as $color) {
            $color = (object)$color;
            $tmpColorsNames[] = (object)[
                "title" => "цвет профиля $color->value"
            ];

        }

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

        /*    dd([
                "materials" => $materials,
                "color_names" => $tmpColorsNames,
                "depth_names" => $tmpDepthNames,
                "loops" => $tmpLoops,
                "sizes" => $tmpSizes,
                "colors"=>$tmpColors,
                "variants"=>$tmpDepth
            ]);*/


        return [
            "materials" => $materials,
            "color_names" => $tmpColorsNames,
            "depth_names" => $tmpDepthNames,
            "loops" => $tmpLoops,
            "sizes" => $tmpSizes,
            "colors" => $tmpColors,
            "variants" => $tmpDepth
        ];
    }

    public function getPreparedPrices(Request $request)
    {
        return response()->json($this->preparePrices());
    }


    public function exportPrices(Request $request)
    {
        return Excel::download(new PriceV3Export($this->preparePrices()),
            'шаблон цены.xlsx');
    }

    public function getFormatted()
    {

        $sizes = Size::query()
            ->where("type", "sizes")
            ->get();
        $loops = Size::query()
            ->where("type", "loops")
            ->get();

        $tmp = [];

        foreach ($sizes as $size) {

            $size = (object)$size;

            $loop = Collection::make($loops)
                ->where("width", $size->width)
                ->where("height", $size->height)
                ->where("material_id", $size->material->id)
                ->first() ?? null;

            if (empty($tmp)) {
                $tmp[] = (object)[
                    "id" => $size->id,
                    "width" => $size->width,
                    "height" => $size->height,
                    "loops" => (object)[
                        "count" =>  (int)($loop->value ?? 0),
                        "price" => $loop->price ?? [
                                "wholesale" => 0,
                                "dealer" => 0,
                                "retail" => 0,
                                "cost" => 0,
                            ],
                    ],
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
                        "loops" => (object)[
                            "count" => (int)($loop->value ?? 0),
                            "price" => $loop->price ?? [
                                    "wholesale" => 0,
                                    "dealer" => 0,
                                    "retail" => 0,
                                    "cost" => 0,
                                ],
                        ],
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
                        // dd($item->materials);
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


        $colors = Color::query()
            ->orderBy("order_position", "asc")
            ->get();

        $tmpColors = [];

        foreach ($colors as $color) {

            if ($color->assign_with_size) {
                $sizes = Size::query()
                    ->where("type", "colors")
                    ->where("value", $color->title)
                    ->select(
                        'width',
                        'height',
                        'price')
                    ->get();
            }

            $color->sizes = $color->assign_with_size ? ($sizes ?? []) : [$color->price];
            unset($color->price);
            $tmpColors[] = $color;
        }

        $tmpDepth = [];

        $depth = Size::query()
            ->where("type", "depth")
            ->get();

        foreach ($depth as $d) {

            $obj = (object)[
                "width" => $d->width,
                "height" => $d->height,
                "price" => $d->price,

            ];

            if (isset($tmpDepth[$d->value]))
                $tmpDepth[$d->value][] = $obj;
            else
                $tmpDepth[$d->value] = [$obj];

        }

        $response = [
            "prices" => $tmp,
            "depth" => $tmpDepth,
            "materials" => Material::query()
                ->orderBy("order_position", "asc")
                ->get(),
            "handles" => Handle::query()
                ->orderBy("order_position", "asc")
                ->get(),
            "hinges" => Hinge::query()
                ->orderBy("order_position", "asc")
                ->get(),
            "door_variants" => DoorVariant::query()
                ->get(),
            "colors" => $tmpColors

        ];

        file_put_contents(public_path() . '\sizes.json', json_encode($response));

        return response()->json($response);

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
                    'price' => (object)[
                        "wholesale" => $basePrice,
                        "dealer" => $basePrice,
                        "retail" => $basePrice,
                        "cost" => $basePrice,
                    ],
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
            $tmp = (object)$size->price;
            $size->price = (object)[
                "wholesale" => $tmp->wholesale * ($size->price_koef ?? 1),
                "dealer" => $tmp->dealer * ($size->price_koef ?? 1),
                "retail" => $tmp->retail * ($size->price_koef ?? 1),
                "cost" => $tmp->cost * ($size->price_koef ?? 1),
            ];// $price * ($size->price_koef ?? 1);


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
        $type = $request->type ?? null;

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

        if (!is_null($type))
            $sizes = $sizes
                ->where("type", $type);

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
                'price' => (object)[
                    "wholesale" => 0,
                    "dealer" => 0,
                    "retail" => 0,
                    "cost" => 0,
                ],
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
        $usePriceKoef = ($request->use_price_koef ?? false) == "true";

        $tmp = $this->uploadDocuments(
            $request->hasFile('files') ?
                $request->file('files') : null);

        if ($needRewrite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('sizes')->truncate();
        }

        Material::query()->truncate();



        foreach ($tmp as $file)
            Excel::import(new PriceMultiSheetImport($usePriceKoef), storage_path("app/public/documents/" . $file));


        if ($usePriceKoef)
            $this->importRecountPrice();

        //  }

        return response()->noContent();
    }

    public function store(Request $request)
    {
        $request->validate([
            'width' => "required",
            'height' => "required",
            'type' => "required",
        ]);

        $id = $request->id ?? null;

        $material = !is_null($request->material_id) ?
            Material::query()->find($request->material_id ?? null) : null;

        $priceData = json_decode($request->price ?? '[]');

        $tmpData = [
            'width' => $request->width ?? 0,
            'height' => $request->height ?? 0,
            'material_id' => $material->id ?? null,
            'price' => (object)[
                "wholesale" => $priceData->wholesale ?? 0,
                "dealer" => $priceData->dealer ?? 0,
                "retail" => $priceData->retail ?? 0,
                "cost" => $priceData->cost ?? 0,
            ],
            'price_koef' => $request->price_koef ?? 0,
            'value' => $request->value ?? null,
            'type' => $request->type ?? null,
        ];

        if (is_null($id) && ($request->type == "sizes" || $request->type == "loops")) {

            $isUniq = is_null(Size::query()
                ->where("width", $request->width)
                ->where("height", $request->height)
                ->where("type", $request->type)
                ->where("material_id", $material->id)
                ->first());

            if (!$isUniq)
                return response()->noContent(400);

        }


        if (is_null($id)) {
            $size = Size::query()
                ->create($tmpData);
        } else {
            $size = Size::query()->find($id);

            if (is_null($size))
                return response()->noContent(404);

            $size->update($tmpData);

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
