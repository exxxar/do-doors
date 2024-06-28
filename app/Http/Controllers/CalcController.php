<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatusEnum;
use App\Exports\CartExport;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderDetail;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use PhpOffice\PhpWord\Exception\CopyFileException;
use PhpOffice\PhpWord\Exception\CreateTemporaryFileException;
use PhpOffice\PhpWord\TemplateProcessor;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;

class CalcController extends Controller
{

    public function downloadCartExcel(Request $request)
    {
        $request->validate([
            "items" => "required",
        ]);


        $items = json_decode($request->items ?? '[]');


        return Excel::download(new CartExport($items), "cart.xls");
    }

    /**
     * @throws TelegramSDKException
     * @throws MpdfException
     */
    public function checkout(Request $request)
    {

        $request->validate([
            "name" => "required",
            "phone" => "required",
            "items" => "required",
        ]);

        $clientId = $request->client_id ?? null;

        $name = $request->name;
        $email = $request->email ?? 'не указано';
        $phone = $request->phone;
        $info = $request->info ?? 'не указана';
        $totalPrice = $request->total_price ?? 0;
        $totalCount = $request->total_count ?? 0;
        $items = json_decode($request->items ?? '[]');

        if (is_null($clientId)) {
            $client = Client::query()
                ->where("phone", $phone)
                ->first();
            if (is_null($client))
                $client = Client::query()->create([
                    'status' => "new_client",
                    'phone' => $phone,
                    'email' => $email ?? null,
                    'user_id' => Auth::user()->id,
                    'title' => $name,
                ]);
        } else
            $client = Client::query()->find($clientId);


        $order = Order::query()->create([
            'contract_number' => null,
            'contract_date' => Carbon::now(),
            'completion_at' => null,
            'client_id' => $client->id,
            'status' => OrderStatusEnum::NewOrder,
            'source' => $request->source ?? "crm",
            'contact_person' => $name,
            'phone' => $phone,
            'organizational_form' => $client->status ?? 'new_client',
            'contract_amount' => $totalPrice,
            'paid' => 0,
            'debt' => 0,
            'profit' => 0,
        ]);

        foreach ($items as $item) {

            OrderDetail::query()->create([
                'order_id' => $order->id,
                'door_type' => $item->product->title ?? null,
                'count' => $item->product->count ?? 0,
                'price' => $item->product->price ?? 0,
                'comment' => $item->product->comment ?? null,
                'purpose' => $item->product->purpose ?? null,
                'door' => $item->product
            ]);

        }

        $tmp = [
            'chat_id' => env("TELEGRAM_CHANNEL_ID"),
            "text" => "#заказ\nПоступил новый заказ!\n"
                . "Имя клиент: $name\n"
                . "E-mail: $email\n"
                . "Телефон: $phone\n"
                . "Доп.инфо: $info\n"
                . "Общее кол-во товара: $totalCount ед.\n"
                . "Цена товара: $totalPrice руб.\n",
            "parse_mode" => "HTML",
        ];

        $telegram = new Api(env("TELEGRAM_BOT_TOKEN"));
        $telegram->sendMessage($tmp);

        $mpdf = new Mpdf(['format' => 'A4-P']);
        $current_date = Carbon::now("+3:00")->format("Y-m-d H:i:s");

        $number = Str::uuid();

        $mpdf->WriteHTML(view("pdf.order-v2", [
            "name" => $name,
            "order_id" => $number,
            "current_date" => $current_date,
            "email" => $email,
            "phone" => $phone,
            "info" => $info,
            "total_price" => $totalPrice,
            "total_count" => $totalCount,
            "items" => $items
        ]));

        $file = $mpdf->Output("order-$number.pdf", \Mpdf\Output\Destination::STRING_RETURN);

        $excelFileName = Str::uuid() . ".xls";

        $timeFragment = Carbon::now("+3:00")->format("Y-m-d-H-i-s");

        Excel::store(new CartExport($items), $excelFileName);

        $telegram->sendDocument([
            'chat_id' => env("TELEGRAM_CHANNEL_ID"),
            "document" => InputFile::createFromContents(Storage::get("$excelFileName"), "order-" . $timeFragment . ".xls"),
            "parse_mode" => "HTML",
        ]);

        Storage::delete($excelFileName);

        $telegram->sendDocument([
            'chat_id' => env("TELEGRAM_CHANNEL_ID"),
            "document" => InputFile::createFromContents($file, "order-" . $timeFragment . ".pdf"),
            "parse_mode" => "HTML",
        ]);

        $path = storage_path() . "/app";
        if (!file_exists($path . "/demo.docx")) {
            try {
                $templateProcessor = new TemplateProcessor($path . "/demo.docx");
                $templateProcessor->setValue('name', $name);
                $templateProcessor->setValue('email', $email);
                $templateProcessor->setValue('phone', $phone);
                $templateProcessor->setValue('order_id', $number);
                $templateProcessor->setValue('info', $info);
                $templateProcessor->setValue('total_price', $totalPrice);
                $templateProcessor->setValue('total_count', $totalCount);
                $templateProcessor->setValue('current_payed', 0);
                $templateProcessor->setValue('payed_percent', 0);
                $templateProcessor->setValue('delivery_terms', 0);
                $templateProcessor->saveAs($path . "/demo.docx");
            } catch (CopyFileException $e) {
            } catch (CreateTemporaryFileException $e) {
            }


        }
    }
}
