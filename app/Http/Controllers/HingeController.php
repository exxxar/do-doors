<?php

namespace App\Http\Controllers;

use App\Http\Requests\HingeStoreRequest;
use App\Http\Requests\HingeUpdateRequest;
use App\Http\Resources\HingeCollection;
use App\Http\Resources\HingeResource;
use App\Models\Hinge;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;

class HingeController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/HingesPage');
    }

    public function getHingeList(Request $request): HingeCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $hinges = Hinge::query();

        if (!is_null($search))
            $hinges = $hinges
                ->where("title", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $hinges = $hinges->orderBy($order, $direction);

        return new HingeCollection($hinges->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);


        $id = $request->id ?? null;

        $priceData = json_decode($request->price ?? '[]');

        if (is_null($id))
            $hinge = Hinge::query()
                ->create([
                    "title" => $request->title ?? null,
                    'price' => (object)[
                        "wholesale" => $priceData->wholesale ?? 0,
                        "dealer" => $priceData->dealer ?? 0,
                        "retail" => $priceData->retail ?? 0,
                        "cost" => $priceData->cost ?? 0,
                    ],
                ]);
        else {
            $hinge = Hinge::query()->find($id);

            if (is_null($hinge))
                return response()->noContent(404);

            $hinge->update([
                "title" => $request->title ?? null,
                'price' => (object)[
                    "wholesale" => $priceData->wholesale ?? 0,
                    "dealer" => $priceData->dealer ?? 0,
                    "retail" => $priceData->retail ?? 0,
                    "cost" => $priceData->cost ?? 0,
                ],
            ]);

        }

        return new HingeResource($hinge);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $hinge = Hinge::query()->find($id);

        if (is_null($hinge))
            return response()->noContent(404);

        $hinge->delete();

        return response()->noContent(200);
    }
}
