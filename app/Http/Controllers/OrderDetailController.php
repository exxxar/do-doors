<?php

namespace App\Http\Controllers;


use App\Http\Resources\OrderDetailCollection;
use App\Http\Resources\OrderDetailResource;
use App\Models\OrderDetail;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;

class OrderDetailController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/OrderDetailsPage');
    }

    public function getOrderDetailList(Request $request): OrderDetailCollection
    {
        $request->validate([
           "order_id"=>"required"
        ]);

        $search = $request->search ?? null;
        $orderDetail = $request->orderDetail ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $orderDetails = OrderDetail::query()
            ->where("order_id", $request->order_id);

        if (!is_null($search))
            $orderDetails = $orderDetails
                ->where("title", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $orderDetails = $orderDetails->orderBy($orderDetail, $direction);

        return new OrderDetailCollection($orderDetails->paginate($size));
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

        if (is_null($id))
            $orderDetail = OrderDetail::query()
                ->create([
                    "title" => $request->title ?? null,
                    'price' => $request->price ?? 0,
                    'color' => $request->color ?? null,
                    'variants' => $variants
                ]);
        else {
            $orderDetail = OrderDetail::query()->find($id);

            if (is_null($orderDetail))
                return response()->noContent(404);

            $orderDetail->update([
                "title" => $request->title ?? null,
                'price' => $request->price ?? 0,
                'color' => $request->color ?? null,
                'variants' => $variants
            ]);

        }

        return new OrderDetailResource($orderDetail);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $orderDetail = OrderDetail::query()->find($id);

        if (is_null($orderDetail))
            return response()->noContent(404);

        $orderDetail->delete();

        return response()->noContent(200);
    }
}
