<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Http\Resources\ServiceCollection;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Inertia\Inertia;

class ServiceController extends Controller
{
    use Utility;

    public function importFromMoySklad(Request $request)
    {

        $sklad = new \App\Services\MoySkladService();

        $needPaths = explode(',', env('MOYSKLAD_SERVICES'));

        // dd($needPaths);

        $offset = 0;
        $tmpServices = [];

        do {

            $tmpSklad = $sklad->getServices(["offset" => $offset])["rows"];
            $offset += count($tmpSklad ?? []);

            foreach ($needPaths as $path) {
                $prods = array_values(\Illuminate\Support\Collection::make($tmpSklad)
                    ->where("pathName", $path)
                    ->all());


                foreach ($prods as $prod) {

                    $prod = (object)$prod;

                    $prices = [
                        "wholesale" => $prod->buyPrice["value"] ?? 0,
                        "dealer" => $prod->buyPrice["value"] ?? 0,
                        "retail" => $prod->buyPrice["value"] ?? 0,
                        "cost" => $prod->buyPrice["value"] ?? 0,
                    ];


                    $tmpServices[] = (object)[
                        'title' => $prod->name ?? '-',
                        'type' => "service_delivery",
                        'price' => $prices,
                        "description" => $prod->description ?? '-',
                        "is_active" => true,
                    ];

                }
            }
        } while (count($tmpSklad) > 0);

        foreach ($tmpServices as $tmpService) {
            $service = \App\Models\Service::query()
                ->where("title", $tmpService->title)
                ->first();

            if (is_null($service))
                \App\Models\Service::query()
                    ->create((array)$tmpService);
            else
                $service->update((array)$tmpService);

        }

        return response()->noContent();

    }

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/ServicesPage');
    }

    public function getServiceListByType(Request $request): ServiceCollection
    {

        $request->validate([
            "type" => "required"
        ]);

        $type = $request->type;

        $services = Service::query()
            ->where("type", $type)
            ->get();

        return new ServiceCollection($services);
    }

    public function getServiceList(Request $request): ServiceCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $services = Service::query();

        if (!is_null($search))
            $services = $services
                ->where("title", 'like', "%$search%")
                ->orWhere("description", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $services = $services->orderBy($order, $direction);

        return new ServiceCollection($services->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);


        $id = $request->id ?? null;

        $priceData = json_decode($request->price ?? '[]');

        $tmp = [
            "title" => $request->title ?? null,
            "is_active" => ($request->is_active ?? false) == "true",
            "order_position" => $request->order_position ?? 0,
            "type" => $request->type ?? null,
            "description" => $request->description ?? null,
            'price' => (object)[
                "wholesale" => $priceData->wholesale ?? 0,
                "dealer" => $priceData->dealer ?? 0,
                "retail" => $priceData->retail ?? 0,
                "cost" => $priceData->cost ?? 0,
            ],
        ];

        if (is_null($id))
            $service = Service::query()
                ->create($tmp);
        else {
            $service = Service::query()->find($id);

            if (is_null($service))
                return response()->noContent(404);

            $service->update($tmp);

        }

        return new ServiceResource($service);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $service = Service::query()->find($id);

        if (is_null($service))
            return response()->noContent(404);

        $service->delete();

        return response()->noContent(200);
    }
}
