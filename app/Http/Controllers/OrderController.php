<?php

namespace App\Http\Controllers;

use App\Classes\DocumentLogic;
use App\Exports\Cart\MultiSheetsCartExport;
use App\Exports\OrderExport;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Resources\OrderCollection;
use App\Http\Resources\OrderResource;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use MessageFormatter;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;

class OrderController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/OrdersPage');
    }

    public function editDoorInOrder(Request $request)
    {

    }

    public function updateContractTemplates(Request $request)
    {

        $request->validate([
            "type" => "required",
            "file" => "required"
        ]);

        $path = storage_path('app/');

        $type = $request->type ?? 0;
        $file = $request->file ?? null;

        if (is_null($file))
            return response()->noContent(400);

        $name = $type == 0 ? "договор с ИП.docx" : ($type == 1 ? "договор с ООО.docx" : "договор с ФЛ.docx");

        if (file_exists($path . "/" . $name))
            unlink($path . "/" . $name);
        $file->move($path, $name);

        return response()->noContent(200);
    }

    public function downloadFilteredOrdersExcel(Request $request)
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $type = $request->type ?? null;
        $ids = $request->ids ?? null;

        if (!is_null($ids))
            $ids = explode(',', $ids);

        $df = $request->df ?? null;
        $dt = $request->dt ?? null;

        $orders = Order::query();

        if (!is_null($search))
            $orders = $orders
                ->where("contract_number", 'like', "%$search%")
                ->orWhere("phone", 'like', "%$search%")
                ->orWhere("contract_amount", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        if ($type == "multiply") {
            $orders = $orders
                ->whereIn("id", $ids);
        }

        if (!is_null($df) && !is_null($dt))
            $orders = $orders
                ->whereBetween("contract_date", [
                    Carbon::createFromTimestamp(substr($df, 0, strlen($df) - 3))->format('Y-m-d H:i:s'),
                    Carbon::createFromTimestamp(substr($dt, 0, strlen($df) - 3))->format('Y-m-d H:i:s'),
                ]);

        $orders = $orders->orderBy($order, $direction)
            ->get();

        if (count($orders) == 0)
            return view("error", [
                "message" => "Заказы с указанным идентификатором не найдены"
            ]);

        $ids = array_values($orders->pluck("id")->toArray());

        $details = OrderDetail::query()
            ->with(["order"])
            ->whereIn("order_id", $ids)
            ->get();

        return Excel::download(new OrderExport(
            $orders,
            $details,
        ), "filtered-orders-tasks.xlsx");
    }

    public function downloadOrderExcel(Request $request, $id)
    {

        $order = Order::query()
            ->where("id", $id)
            ->first();

        $details = OrderDetail::query()
            ->where("order_id", $id)
            ->get();

        if (is_null($order ?? null))
            return view("error", [
                "message" => "Заказ с указанным идентификатором не найден"
            ]);

        $client = Client::query()
            ->where("id", $order->client_id)
            ->first();


        $buyerData = $client->getBueryData();


        $items = [];

        foreach ($details as $detail) {
            $door = (object)$detail->door;
            $items[] = $door;
        }

        return Excel::download(new MultiSheetsCartExport($items, $buyerData), "заказ $id.xlsx");

        /*return Excel::download(new OrderExport(
            $orders,
            $details,
        ), "orders-tasks-$id.xlsx");*/
    }

    public function getOrderList(Request $request): OrderCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');
        $df = $request->df ?? null;
        $dt = $request->dt ?? null;


        $orders = Order::query()
            ->with(['details']);

        if (!is_null($search))
            $orders = $orders
                ->where("contract_number", 'like', "%$search%")
                ->orWhere("phone", 'like', "%$search%")
                ->orWhere("contract_amount", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        if (!is_null($df) && !is_null($dt))
            $orders = $orders
                ->whereBetween("contract_date", [
                    Carbon::parse($df)->format('Y-m-d H:i:s'),
                    Carbon::parse($dt)->format('Y-m-d H:i:s'),
                ]);

        $orders = $orders->orderBy($order, $direction);

        return new OrderCollection($orders->paginate($size));
    }

    public function downloadTemplate(Request $request)
    {
        $request->validate([
            "type" => "required",
        ]);

        $name = $request->type == 0 ? "договор с ИП.docx" : ($request->type == 1 ? "договор с ООО.docx" : "договор с ФЛ.docx");

        $headers = array(
            'Content-Type:  application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );

        $path = storage_path() . "/app";
        $file = $path . "/$name";

        return response()->download($file, $name, $headers);
    }

    public function downloadContract(Request $request)
    {
        $request->validate([
            "o" => "required",
            "c" => "required",

        ]);

        $path = storage_path() . "/app";

        $orderId = $request->o ?? null;
        $clientId = $request->c ?? null;


        $client = Client::query()->find($clientId);
        $order = Order::query()->find($orderId);


        if (is_null($client))
            return view("error", [
                "message" => "Такой клиент не найден в системе!"
            ]);

        if (is_null($order))
            return view("error", [
                "message" => "Такой заказ не найден в системе!"
            ]);

        $nds = ($order->organizational_form ?? 'legal_entity') == 'legal_entity' ? 1 : 0;

        $name = $nds == 0 ? "договор с ИП.docx" : "договор с ООО.docx";

        $title = str_replace('"', "", $client->title);
        $title = str_replace("'", "", $title);

        $generatedName = $nds == 0 ? "договор с ИП с $title.docx" : "договор с ООО с $title.docx";

        $preparedRequisites = null;

        if (count($client->requisites ?? []) === 1) {
            $tmp = (object)$client->requisites[0];
            $preparedRequisites = "Получатель: " . ($client->title ?? '-') .
                " Счет получателя:" . ($tmp->checking_account ?? '-') .
                " БИК: " . ($tmp->bik ?? '-') .
                " Наименование банка: " . ($tmp->bank ?? '-') .
                " Корреспондентский счет: " . ($tmp->correspondent_account ?? '-') .
                " ИНН: " . ($client->inn ?? '-') .
                " КПП:" . ($client->kpp ?? '-');
        }

        if (count($client->requisites ?? []) > 1) {
            $tmp = (object)Collection::make($client->requisites)->where("is_main", true)->first();

            if (is_null($tmp ?? null))
                $tmp = (object)$client->requisites[0];

            $preparedRequisites = "Получатель: " . ($client->title ?? '-') .
                " Счет получателя:" . ($tmp->checking_account ?? '-') .
                " БИК: " . ($tmp->bik ?? '-') .
                " Наименование банка: " . ($tmp->bank ?? '-') .
                " Корреспондентский счет: " . ($tmp->correspondent_account ?? '-') .
                " ИНН: " . ($client->inn ?? '-') .
                " КПП:" . ($client->kpp ?? '-');
        }

        if (!file_exists($path . "/" . $name)) {
            return view("error", [
                "message" => "Не найден шаблон договора!"
            ]);
        }
        $buyerData = $client->getBueryData();

        $work_days_string = $order->work_days . "(" . (new MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => $order->work_days]) . ")";

        $templateProcessor = new TemplateProcessor($path . "/$name");

        $templateProcessor->setValue('date_doc', Carbon::now()->format('d-m-Y'));
        $templateProcessor->setValue('numb_doc', $order->id);
        $templateProcessor->setValue('title', $name);
        $templateProcessor->setValue('member', $client->fio ?? '-');
        $templateProcessor->setValue('fio', $fam_initial ?? '-');
        $templateProcessor->setValue('email', $client->email ?? '-');
        $templateProcessor->setValue('phone', $client->phone ?? '-');
        $templateProcessor->setValue('fact_address', $client->fact_address ?? '-');
        $templateProcessor->setValue('law_address', $client->law_address ?? '-');
        $templateProcessor->setValue('inn', $client->inn ?? '-');
        $templateProcessor->setValue('ogrn', $client->ogrn ?? '-');
        $templateProcessor->setValue('kpp', $client->kpp ?? '-');
        $templateProcessor->setValue('okpo', $client->okpo ?? '-');

        $templateProcessor->setValue('order_id', $order->id);
        $templateProcessor->setValue('info', $order->info ?? '-');
        $templateProcessor->setValue('total_price', $order->total_price ?? 0);
        $templateProcessor->setValue('total_count', $order->total_count ?? 0);
        $templateProcessor->setValue('current_payed', $order->current_payed ?? 0);
        $templateProcessor->setValue('payed_percent', $order->payed_percent ?? 0);
        $templateProcessor->setValue('last_payment', floatval($order->total_price) - floatval($order->current_payed));
        $templateProcessor->setValue('delivery_terms', $order->delivery_terms ?? '-');
        $templateProcessor->setValue('work_days', $work_days_string);

        // requisites
        $templateProcessor->setValue('bik', $buyerData["buyer_bank_bic"]);
        $templateProcessor->setValue('ksch', $buyerData["buyer_correspondent_account"]);
        $templateProcessor->setValue('rsch', $buyerData["buyer_checking_account"]);
        $templateProcessor->setValue('bank_name', $buyerData["buyer_bank_name"]);
        /*    $templateProcessor->setValue('passport', $passport);
            $templateProcessor->setValue('passport_issued', $passport_issued);*/
        if (!is_null($preparedRequisites))
            $templateProcessor->setValue('requisites', $preparedRequisites);

        $doc = new DocumentLogic();
        $sellerParams = $doc->getAllSellerParameters($nds == 1);

        foreach ($sellerParams as $key => $value)
            $templateProcessor->setValue($key, $value);

        $templateProcessor->saveAs($path . "/$generatedName");

        $headers = array(
            'Content-Type:  application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        );
        $file = $path . "/$generatedName";

        return response()->download($file, $generatedName, $headers);
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
            $order = Order::query()
                ->create([
                    "title" => $request->title ?? null,
                    'price' => $request->price ?? 0,
                    'color' => $request->color ?? null,
                    'variants' => $variants
                ]);
        else {
            $order = Order::query()->find($id);

            if (is_null($order))
                return response()->noContent(404);

            $order->update([
                "title" => $request->title ?? null,
                'price' => $request->price ?? 0,
                'color' => $request->color ?? null,
                'variants' => $variants
            ]);

        }

        return new OrderResource($order);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $order = Order::query()->find($id);

        if (is_null($order))
            return response()->noContent(404);

        $order->delete();

        return response()->noContent(200);
    }
}
