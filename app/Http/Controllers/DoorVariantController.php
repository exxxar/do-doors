<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoorVariantStoreRequest;
use App\Http\Requests\DoorVariantUpdateRequest;
use App\Http\Resources\DoorVariantCollection;
use App\Http\Resources\DoorVariantResource;
use App\Models\DoorVariant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class DoorVariantController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/DoorVariantsPage');
    }

    public function getDoorVariantList(Request $request): DoorVariantCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $doorVariants = DoorVariant::query();

        if (!is_null($search))
            $doorVariants = $doorVariants
                ->where("title", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $doorVariants = $doorVariants->orderBy($order, $direction);

        return new DoorVariantCollection($doorVariants->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);


        $id = $request->id ?? null;

        if (is_null($id))
            $doorVariant = DoorVariant::query()
                ->create([
                    "title" => $request->title ?? null,
                    'price' => $request->price ?? 0,
                ]);
        else {
            $doorVariant = DoorVariant::query()->find($id);

            if (is_null($doorVariant))
                return response()->noContent(404);

            $doorVariant->update([
                "title" => $request->title ?? null,
                'price' => $request->price ?? 0,
            ]);

        }

        return new DoorVariantResource($doorVariant);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $doorVariant = DoorVariant::query()->find($id);

        if (is_null($doorVariant))
            return response()->noContent(404);

        $doorVariant->delete();

        return response()->noContent(200);
    }
}
