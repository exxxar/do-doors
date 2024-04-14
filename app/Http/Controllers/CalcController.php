<?php

namespace App\Http\Controllers;

use App\Exports\CartExport;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;

class CalcController extends Controller
{

    public function downloadCartExcel(Request $request){
        $request->validate([
            "items" => "required",
        ]);


        $items = json_decode($request->items ?? '[]');


        return Excel::download(new CartExport($items),"cart.xls");
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


        $name = $request->name;
        $email = $request->email ?? 'не указано';
        $phone = $request->phone;
        $info = $request->info ?? 'не указана';
        $totalPrice = $request->total_price ?? 0;
        $totalCount = $request->total_count ?? 0;
        $items = json_decode($request->items ?? '[]');


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

        $excelFileName = Str::uuid().".xls";

        $timeFragment = Carbon::now("+3:00")->format("Y-m-d-H-i-s");

        Excel::store(new CartExport($items), $excelFileName);

        $telegram->sendDocument([
            'chat_id' => env("TELEGRAM_CHANNEL_ID"),
            "document" => InputFile::createFromContents(Storage::get("$excelFileName"), "order-" . $timeFragment . ".xls"),
            "parse_mode" => "HTML",
        ]);

        Storage::delete($excelFileName);

        $telegram->sendDocument( [
            'chat_id' => env("TELEGRAM_CHANNEL_ID"),
            "document" => InputFile::createFromContents($file, "order-" . $timeFragment . ".pdf"),
            "parse_mode" => "HTML",
        ]);
    }
}
