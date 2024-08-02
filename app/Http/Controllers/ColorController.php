<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorStoreRequest;
use App\Http\Requests\ColorUpdateRequest;
use App\Http\Resources\ColorCollection;
use App\Http\Resources\ColorResource;
use App\Models\Color;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class ColorController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/ColorsPage');
    }

    public function getColorList(Request $request): ColorCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $colors = Color::query();

        if (!is_null($search))
            $colors = $colors
                ->where("title", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $colors = $colors->orderBy($order, $direction);

        return new ColorCollection($colors->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);


        $id = $request->id ?? null;

        $priceData = json_decode($request->price ?? '[]');
        $excludes = json_decode($request->excludes ?? '[]');

        $tmp = [
            "title" => $request->title ?? null,
            'price' => (object)[
                "wholesale" => $priceData->wholesale ?? 0,
                "dealer" => $priceData->dealer ?? 0,
                "retail" => $priceData->retail ?? 0,
                "cost" => $priceData->cost ?? 0,
            ],
            'code' => $request->code ?? null,
            'type' => $request->type ?? null,
            'excludes' => $excludes,
        ];

        if (is_null($id))
            $color = Color::query()
                ->create($tmp);
        else {
            $color = Color::query()->find($id);

            if (is_null($color))
                return response()->noContent(404);

            $color->update($tmp);

        }

        return new ColorResource($color);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $color = Color::query()->find($id);

        if (is_null($color))
            return response()->noContent(404);

        $color->delete();

        return response()->noContent(200);
    }
}
