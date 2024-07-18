<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;


use Telegram\Bot\Api; 



class LandingController extends Controller
{

	public function sendReqCallToBot(Request $request)
	{

		$request->validate([
			"phone" => "required",
			"fio" => "required"
		]);
		// try {

		// 	$tmp = [
		// 		'chat_id' => env("TELEGRAM_CHANNEL_ID"),
		// 		"text" => "#звонок\nПоступил новый запрос на обратный звонок!\n"
		// 			. "Имя клиента: $request->fio\n"
		// 			. "Телефон: $request->phone\n"
		// 			. "Сообщение: $request->msg\n",
		// 		"parse_mode" => "HTML",
		// 	];

		// 	$telegram = new Api(env("TELEGRAM_BOT_TOKEN"));
		// 	$telegram->sendMessage($tmp);



		// } catch (Exception $e) {
		// 	// вот тут нужно время еще разобраться

		// 	return back()->with([
		// 		'customError' => [
		// 			'field' => 'name',
		// 			'message' => 'The name is invalid',
		// 		]
		// 	]);
		// }
		
return $request;


		// return response()->noContent(200);
	}
}