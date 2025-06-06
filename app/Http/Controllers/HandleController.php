<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandleStoreRequest;
use App\Http\Requests\HandleUpdateRequest;
use App\Http\Resources\HandleCollection;
use App\Http\Resources\HandleResource;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Imports\HandleMultiSheetImport;
use App\Imports\PriceMultiSheetImport;
use App\Models\Handle;
use App\Models\Material;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class HandleController extends Controller
{
    use Utility;

    public function importFromMoySklad(Request $request)
    {

        $sklad = new \App\Services\MoySkladService();

        $needPaths = explode(',', env('MOYSKLAD_HANDLES'));

        $offset = 0;
        $tmpHandles = [];

        do {

            $tmpSklad = $sklad->getProducts(["offset" => $offset])["rows"];
            $offset += count($tmpSklad ?? []);

            foreach ($needPaths as $path) {
                $prods = array_values(\Illuminate\Support\Collection::make($tmpSklad)
                    ->where("pathName", $path)
                    ->all());


                foreach ($prods as $prod) {

                    $prod = (object)$prod;

                    $images = [];


                    if (count($prod->images["rows"] ?? []) > 0) {
                        foreach ($prod->images as $img) {
                            $img = (object)$img;

                            if (!is_null($img->filename ?? null))
                                $images[] = (object)[
                                    "image" => $img->filename,
                                    "title" => $img->title ?? '-',
                                    "description" => null
                                ];
                        }
                    }

                    $isImageInDescription = false;
                    if (preg_match('/\.(jpg|jpeg|gif|png|bmp)$/i', ($prod->description ?? ''))) {
                        $isImageInDescription = true;

                        $images[] = (object)[
                            "image" => $prod->description,
                            "title" => null,
                            "description" => null
                        ];
                    }

                    $prices = [
                        "wholesale" => $prod->buyPrice["value"] ?? 0,
                        "dealer" => $prod->buyPrice["value"] ?? 0,
                        "retail" => $prod->buyPrice["value"] ?? 0,
                        "cost" => $prod->buyPrice["value"] ?? 0,
                    ];


                    $tmpHandles[] = (object)[
                        'title' => $prod->name ?? '-',
                        'price' => $prices,
                        'variants' => $images,
                        "sku" => $prod->article ?? '-',
                        "comment" => $isImageInDescription ? '' : ($prod->description ?? '-'),
                        "weight" => $prod->weight ?? 0,
                        "serial" => $prod->code ?? '-',
                        /*  "material",
                      "brand",
                        "material_description",
                        "coverage",
                        "model",
                        "characteristics",
                        "base_shape",
                        "socket_diameter",
                        "square_length",
                        "guarantee",
                        "dimensions",*/
                    ];

                }
            }
        } while (count($tmpSklad) > 0);

        foreach ($tmpHandles as $tmpHandle) {
            $handle = \App\Models\Handle::query()
                ->where("title", $tmpHandle->title)
                ->first();

            if (is_null($handle))
                \App\Models\Handle::query()
                    ->create((array)$tmpHandle);
            else
                $handle->update((array)$tmpHandle);

        }

        return response()->noContent();

    }

    public function import(Request $request)
    {

        $tmp = $this->uploadDocuments(
            $request->hasFile('files') ?
                $request->file('files') : null);

        $needRewrite = ($request->need_rewrite ?? false) == "true";

        if ($needRewrite) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('handles')->truncate();
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        foreach ($tmp as $file) {
            $path = storage_path("app/public/documents/" . $file);
            Excel::import(new HandleMultiSheetImport($path), $path);
        }


        return response()->noContent();
    }


    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/HandlesPage');
    }

    public function getHandleList(Request $request): HandleCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $handles = Handle::query();

        if (!is_null($search))
            $handles = $handles
                ->where("title", 'like', "%$search%")
                ->orWhere("color", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $handles = $handles->orderBy($order, $direction);

        return new HandleCollection($handles->paginate($size));
    }

    public function fastStore(Request $request)
    {
        $request->validate([
            "handles.*" => "required"
        ]);

        $handles = $request->handles ?? [];

        foreach ($handles as $handle) {
            $handle = (object)$handle;
            $tmp = [
                "title" => $handle->title ?? null,
                'price' => (object)[
                    "wholesale" => $handle->price ?? 0,
                    "dealer" => $handle->price ?? 0,
                    "retail" => $handle->price ?? 0,
                    "cost" => $handle->price ?? 0,
                ],
                'color' => null,
                'variants' => []
            ];


            $handle = Handle::query()
                ->create($tmp);

        }

        return response()->noContent();

    }

    public function fastEdit(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);

        $priceData = (object)$request->price;

        $id = $request->id ?? null;

        $handle = Handle::query()->find($id);

        if (is_null($handle))
            return response()->noContent(404);

        $handle->price = (object)[
            "wholesale" => $priceData->wholesale ?? 0,
            "dealer" => $priceData->dealer ?? 0,
            "retail" => $priceData->retail ?? 0,
            "cost" => $priceData->cost ?? 0,
        ];
        $handle->title = $request->title ?? null;

        $handle->save();

        return new HandleResource($handle);

    }

    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);

        $variants = json_decode($request->variants ?? '[]');
        $imageInfo = json_decode($request->uploaded_image_info ?? '[]');


        $tmp = $this->uploadPhotos(
            $request->hasFile('uploaded_variants_image') ?
                $request->file('uploaded_variants_image') : null, true);

        foreach ($tmp as $item)
            foreach ($imageInfo as $key => $info) {
                $info = (object)$info;
                if ($item->original == ($info->image_name ?? null)) {
                    $info->uuid = Str::uuid()->toString();
                    $info->image = $item->current ?? '-';
                    unset($info->image_name);
                }
            }

        $variants = [...$variants, ...$imageInfo];


        $id = $request->id ?? null;

        $priceData = json_decode($request->price ?? '[]');

        $tmp = [
            "title" => $request->title ?? null,
            'price' => (object)[
                "wholesale" => $priceData->wholesale ?? 0,
                "dealer" => $priceData->dealer ?? 0,
                "retail" => $priceData->retail ?? 0,
                "cost" => $priceData->cost ?? 0,
            ],
            'color' => $request->color ?? null,
            'variants' => $variants
        ];

        if (is_null($id))
            $handle = Handle::query()
                ->create($tmp);
        else {
            $handle = Handle::query()->find($id);

            if (is_null($handle))
                return response()->noContent(404);

            $handle->update($tmp);

        }

        return new HandleResource($handle);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $handle = Handle::query()->find($id);

        if (is_null($handle))
            return response()->noContent(404);

        $handle->delete();

        return response()->noContent(200);
    }
}
