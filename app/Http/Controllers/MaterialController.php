<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\MaterialUpdateRequest;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use App\Models\Size;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;

class MaterialController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/MaterialsPage');
    }

    public function getMaterialList(Request $request): MaterialCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $materials = Material::query();

        if (!is_null($search))
            $materials = $materials
                ->where("title", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $materials = $materials->orderBy($order, $direction);

        return new MaterialCollection($materials->paginate($size));
    }


    public function store(Request $request): MaterialResource|\Illuminate\Http\Response
    {
        $request->validate([
            "title" => "required"
        ]);

        $wrapper = json_decode($request->wrapper_variants ?? '[]');
        $door = json_decode($request->door_variants ?? '[]');

        $wrapperImageInfo = json_decode($request->wrapper_images_info ?? '[]');
        $doorImageInfo = json_decode($request->door_images_info ?? '[]');


        $tmp = $this->uploadPhotos(
            $request->hasFile('wrapper_images') ?
                $request->file('wrapper_images') : null, true);

        foreach ($tmp as $item)
            foreach ($wrapperImageInfo as $key => $info) {
                $info = (object)$info;
                if ($item->original == ($info->image_name ?? null)) {
                    $info->uuid = Str::uuid()->toString();
                    $info->image = $item->current ?? '-';
                    unset($info->image_name);
                }
            }

        $wrapper = [...$wrapper, ...$wrapperImageInfo];

        $tmp = $this->uploadPhotos(
            $request->hasFile('door_images') ?
                $request->file('door_images') : null, true);

        foreach ($tmp as $item)
            foreach ($doorImageInfo as $key => $info) {
                $info = (object)$info;
                if ($item->original == ($info->image_name ?? null)) {
                    $info->uuid = Str::uuid()->toString();
                    $info->image = $item->current ?? '-';
                    unset($info->image_name);
                }
            }

        $door = [...$door, ...$doorImageInfo];

        $id = $request->id ?? null;

        if (is_null($id)) {
            $heightList = array_values(Size::query()
                ->distinct()
                ->pluck("height")->toArray());

            $widthList = array_values(Size::query()
                ->distinct()
                ->pluck("width")->toArray());


            $material = Material::query()
                ->create([
                    "title" => $request->title ?? null,
                    'wrapper_variants' => $wrapper,
                    'door_variants' => $door,
                ]);

            $generateData = ($request->need_generate_sizes ?? false) == "true";

            if ($generateData)
                foreach ($heightList as $height)
                    foreach ($widthList as $width)
                        Size::query()->create([
                            'material_id' => $material->id,
                            'width' => $width,
                            'height' => $height,
                            'price' => 0,
                            'price_koef' => 1,
                            'loops_count' => 2,
                        ]);
        } else {
            $material = Material::query()->find($id);

            if (is_null($material))
                return response()->noContent(404);

            $material->update([
                "title" => $request->title ?? null,
                'wrapper_variants' => $wrapper,
                'door_variants' => $door,
            ]);

        }

        return new MaterialResource($material);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $material = Material::query()->find($id);

        if (is_null($material))
            return response()->noContent(404);

        $material->delete();

        return response()->noContent(200);
    }
}
