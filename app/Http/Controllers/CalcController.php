<?php

namespace App\Http\Controllers;

use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Mpdf\Mpdf;
use Mpdf\MpdfException;
use Telegram\Bot\Api;
use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\FileUpload\InputFile;

class CalcController extends Controller
{

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

        $mpdf = new Mpdf(['format' => 'A4-L']);
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

        $tmp = [
            'chat_id' => env("TELEGRAM_CHANNEL_ID"),
            "document" => InputFile::createFromContents($file, "order-" . (Carbon::now("+3:00")->format("Y-m-d-H-i-s")) . ".pdf"),
            "parse_mode" => "HTML",
        ];

        $telegram->sendDocument($tmp);
    }
}
