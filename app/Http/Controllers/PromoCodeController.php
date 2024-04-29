<?php

namespace App\Http\Controllers;

use App\Http\Requests\PromoCodeStoreRequest;
use App\Http\Requests\PromoCodeUpdateRequest;
use App\Http\Resources\PromoCodeCollection;
use App\Http\Resources\PromoCodeResource;
use App\Models\PromoCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PromoCodeController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/PromoCodesPage');
    }

    public function findPromo(Request $request)
    {
        $request->validate([
            "code" => "required"
        ]);

        $code = PromoCode::query()
            ->where("code", $request->code)
            ->first();

        return \response()->json([
            "discount" => is_null($code) ? 0 : ($code->discount ?? 0)
        ]);
    }

    public function getPromoCodesList(Request $request): PromoCodeCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $promoCodes = PromoCode::query();

        if (!is_null($search))
            $promoCodes = $promoCodes
                ->where("code", 'like', "%$search%")
                ->orWhere("description", 'like', "%$search%");

        $promoCodes = $promoCodes->orderBy($order, $direction);

        return new PromoCodeCollection($promoCodes->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "code" => "required|min:5"
        ]);

        $id = $request->id ?? null;

        $tmp = [
            "code" => $request->code ?? null,
            'discount' => $request->discount ?? 0,
            'description' => $request->description ?? null,
            'is_active' => ($request->is_active ?? false) == "true",
            'end_at' => is_null($request->end_at ?? null) ? null : Carbon::parse($request->end_at)->format('Y-m-d H:i:s'),
        ];

        if (is_null($id))
            $promoCode = PromoCode::query()
                ->create($tmp);
        else {
            $promoCode = PromoCode::query()->find($id);

            if (is_null($promoCode))
                return response()->noContent(404);

            $promoCode->update($tmp);

        }

        return new PromoCodeResource($promoCode);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $promoCode = PromoCode::query()->find($id);

        if (is_null($promoCode))
            return response()->noContent(404);

        $promoCode->delete();

        return response()->noContent(200);
    }
}
