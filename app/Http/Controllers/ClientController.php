<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientStoreRequest;
use App\Http\Requests\ClientUpdateRequest;
use App\Http\Resources\ClientCollection;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;

class ClientController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/ClientsPage');
    }

    public function getDataByBik(Request $request){
        $request->validate([
            "bik" => "required"
        ]);

        $result =  Http::withHeader("Content-Type", "application/json")
            ->get("https://bik-info.ru/api.html?type=json&bik=".$request->bik);

        return response()->json($result->json());
    }

    public function getDataByInn(Request $request)
    {
        $request->validate([
            "inn" => "required"
        ]);

       $result = Http::asForm()
            ->withHeader("Content-Type", "application/x-www-form-urlencoded; charset=UTF-8")
            ->post("https://egrul.nalog.ru/", [
                "query" => $request->inn
            ]);

       $result = Http::withHeader("Content-Type", "application/json")
            ->get("https://egrul.nalog.ru/search-result/".$result->json("t"));


       return response()->json($result->json("rows"));
    }


    public function getSelfClientList(Request $request): ClientCollection
    {
        $clients = Client::query()
            ->where("user_id", Auth::user()->id);

        return new ClientCollection($clients->get());
    }

    public function getClientList(Request $request): ClientCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $clients = Client::query();

        if (!is_null($search))
            $clients = $clients
                ->where("title", 'like', "%$search%")
                ->orWhere("phone", 'like', "%$search%")
                ->orWhere("law_address", 'like', "%$search%")
                ->orWhere("inn", 'like', "%$search%")
                ->orWhere("kpp", 'like', "%$search%")
                ->orWhere("ogrn", 'like', "%$search%")
                ->orWhere("okpo", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $clients = $clients->orderBy($order, $direction);

        return new ClientCollection($clients->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "title" => "required"
        ]);

        $requisites = json_decode($request->requisites ?? '[]');


        $id = $request->id ?? null;

        $tmp = [
            'status' => $request->status ?? null,
            'phone' => $request->phone ?? null,
            'email' => $request->email ?? null,
            'fact_address' => $request->fact_address ?? null,
            'comment' => $request->comment ?? null,
            'user_id' => $request->user_id ?? null,
            'title' => $request->title ?? null,
            'law_address' => $request->law_address ?? null,
            'inn' => $request->inn ?? null,
            'kpp' => $request->kpp ?? null,
            'ogrn' => $request->ogrn ?? null,
            'okpo' => $request->okpo ?? null,
            'requisites' => $requisites
        ];

        if (is_null($id))
            $client = Client::query()
                ->create($tmp);
        else {
            $client = Client::query()->find($id);

            if (is_null($client))
                return response()->noContent(404);

            $client->update($tmp);

        }

        return new ClientResource($client);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $client = Client::query()->find($id);

        if (is_null($client))
            return response()->noContent(404);

        $client->delete();

        return response()->noContent(200);
    }
}
