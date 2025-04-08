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

    public function importFromMoySklad(Request $request)
    {

        $sklad = new \App\Services\MoySkladService();

        $offset = 0;
        $tmpClients = [];

        do {

            $tmpSklad = $sklad->getClients(["offset" => $offset])["rows"];
            $offset += count($tmpSklad ?? []);

            $clients = array_values(\Illuminate\Support\Collection::make($tmpSklad)
                ->all());

            foreach ($clients as $client) {

                $client = (object)$client;


                $statuses = ["legal"=>"legal_entity","individual"=>"individual"];

                $tmpClients[] = (object)[
                    'status'=>$statuses[$client->companyType] ?? 'new_client',
                    'phone'=>$client->phone ?? null,
                    'email'=>$client->email ?? null,
                    'fact_address'=>$client->actualAddress ?? null,
                    'comment'=>$client->legalTitle ?? null,
                    'title'=>$client->legalTitle ?? null,
                    'law_address'=>$client->legalAddress ?? null,
                    'inn'=>$client->inn ?? null,
                    'kpp'=>$client->kpp ?? null,
                    'ogrn'=>$client->ogrn ?? null,
                    'okpo'=>$client->okpo ?? null,
                    'fio'=>$client->name ?? null
                ];

            }

        } while (count($tmpSklad) > 0);

        foreach ($tmpClients as $tmpClient) {
            $client = \App\Models\Client::query()
                ->where("phone", $tmpClient->phone)
                ->first();


            if (is_null($client))
                \App\Models\Client::query()
                    ->create((array)$tmpClient);
            else
                $client->update((array)$tmpClient);

        }

        return response()->noContent();

    }

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/ClientsPage');
    }

    public function getDataByBik(Request $request)
    {
        $request->validate([
            "bik" => "required"
        ]);

        $result = Http::withHeader("Content-Type", "application/json")
            ->get("https://bik-info.ru/api.html?type=json&bik=" . $request->bik);

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
            ->get("https://egrul.nalog.ru/search-result/" . $result->json("t"));


        return response()->json($result->json("rows"));
    }


    public function getSelfClientList(Request $request): ClientCollection
    {
        $clients = Client::query()->get();
        //->where("user_id", Auth::user()->id);

        return new ClientCollection($clients);
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
                ->orWhere("id", 'like', "%$search%")
                ->orWhere("fio", 'like', "%$search%");

        $clients = $clients->orderBy($order, $direction);

        return new ClientCollection($clients->paginate($size));
    }


    public function store(Request $request)
    {
        // dd($request);
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
            'requisites' => $requisites,
            'fio' => $request->fio ?? null
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
