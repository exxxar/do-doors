<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialStoreRequest;
use App\Http\Requests\MaterialUpdateRequest;
use App\Http\Resources\MaterialCollection;
use App\Http\Resources\MaterialResource;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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


    public function store(Request $request): MaterialResource | \Illuminate\Http\Response
    {
        $request->validate([
            "title" => "required"
        ]);

        $wrapper = json_decode($request->wrapper_variants ?? '[]');
        $door = json_decode($request->door_variants ?? '[]');

        $tmp = $this->uploadPhotos($request->hasFile('wrapper_images') ? $request->file('wrapper_images') : null);
        $wrapper = [...$wrapper, ...$tmp];
        $tmp = $this->uploadPhotos($request->hasFile('door_images') ? $request->file('door_images') : null);
        $door = [...$door, ...$tmp];

        $id = $request->id ?? null;

        if (is_null($id))
        $material = Material::query()
            ->create([
                "title" => $request->title ?? null,
                'wrapper_variants' => $wrapper,
                'door_variants' => $door,
            ]);
        else {
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
