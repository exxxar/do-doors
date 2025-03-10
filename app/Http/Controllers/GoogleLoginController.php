<?php

namespace App\Http\Controllers;

use App\Classes\ImportDataTrait;
use App\Models\Color;
use App\Models\Material;
use App\Models\Size;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Google\Client;
use Google\Service\Sheets;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Row;
use Revolution\Google\Sheets\Sheets as RSheets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpKernel\Exception\HttpException;

class GoogleLoginController extends Controller
{
    use ImportDataTrait;

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /*   public function onRow($row, $rowIndex)
       {

           if ($rowIndex == 0) {
               unset($row[0]);
               unset($row[1]);
               unset($row[2]);
               foreach (array_values($row) as $item)
                   if (!empty($item)) {

                       $this->materials[] = $item;

                       $hasMaterial = count(Material::query()
                               ->where("title", $item)
                               ->get() ?? []) > 0;

                       if (!$hasMaterial)
                           Material::query()->create([
                               "title" => $item
                           ]);

                   }

               return null;
           }
           if ($rowIndex <= 1) {
               return null;
           }


           if (is_null($row[0] ?? null) || empty($row[0] ?? ''))
               return null;


           $width = (int)filter_var($row[1] ?? 0, FILTER_SANITIZE_NUMBER_INT);// str_replace(" ","",$row[1] ?? 0);
           $height = (int)filter_var($row[0] ?? 0, FILTER_SANITIZE_NUMBER_INT);
           $loopsCount = (int)filter_var($row[2] ?? 0, FILTER_SANITIZE_NUMBER_INT);

           $materialIndex = 0;

           for ($i = 3; $i < count($row); $i += 5) {


               $material = Material::query()->where("title", $this->materials[$materialIndex])->first();

               $price_wholesale = (float)filter_var($row[$i] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
               $price_dealer = (float)filter_var($row[$i + 1] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
               $price_retail = (float)filter_var($row[$i + 2] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
               $price_cost = (float)filter_var($row[$i + 3] ?? 0, FILTER_SANITIZE_NUMBER_FLOAT);
               $priceKoef = floatval($row[$i + 4] ?? 0);


               Size::query()->create([
                   'width' => $width ?? 0,
                   'height' => $height ?? 0,
                   'material_id' => $material->id,
                   'price' => (object)[
                       "wholesale" => $price_wholesale,
                       "dealer" => $price_dealer,
                       "retail" => $price_retail,
                       "cost" => $price_cost,
                   ],
                   'price_koef' => $priceKoef,
                   'loops_count' => $loopsCount,
               ]);

               $materialIndex++;

               if (count($this->materials) == $materialIndex)
                   break;
           }

       }*/


    protected function getGoogleLink(Request $request)
    {
        $request->validate([
            "sheet_id" => "required",
        ]);

        $part = $request->part ?? "sizes";

        $client = new Client();
        $client->setAuthConfig((array)json_decode(file_get_contents(storage_path("app/credentials.json"))));
        $client->setScopes([Sheets::DRIVE, Sheets::SPREADSHEETS]);
        $client->setClientId(env("GOOGLE_CLIENT_ID"));
        $client->setClientSecret(env("GOOGLE_CLIENT_SECRET"));
        $client->setRedirectUri(env("GOOGLE_REDIRECT"));
        $client->setAccessType("offline");
        $client->setState(base64_encode(json_encode([
            "need_rewrite" => ($request->need_rewrite ?? false) == "true",
            "use_price_koef" => ($request->use_price_koef ?? false) == "true",
            "sheet_id" => $request->sheet_id,
            "part"=>$part,
        ])));

        return response()->json(["url" => $client->createAuthUrl()]);
    }

    /**
     * @throws \Google\Exception
     * @throws HttpException
     */
    public function serviceCallback(Request $request)
    {

        $code = $request->all()["code"] ?? null;

        $state = $request->all()["state"] ?? null;

        if (is_null($state))
            return response()->noContent(400);

        $state = base64_decode($state);
        $state = json_decode($state);

        $sheetId = $state->sheet_id ?? null;
        $needRewrite = $state->need_rewrite ?? false;
        $usePriceKoef = $state->use_price_koef ?? false;
        $part = $state->part ?? "sizes";

        // 1_WidWiOLk9FANYSJdcyo32OFGq48QEAZCqJ4rMKrFQo

        $client = new Client();
        $client->setAuthConfig((array)json_decode(file_get_contents(storage_path("app/credentials.json"))));
        $client->setScopes([Sheets::DRIVE, Sheets::SPREADSHEETS]);
        $client->setClientId(env("GOOGLE_CLIENT_ID"));
        $client->setClientSecret(env("GOOGLE_CLIENT_SECRET"));
        $client->setRedirectUri(env("GOOGLE_REDIRECT"));
        $client->setAccessType("offline");


        if ($part=="sizes") {
            if (!is_null($code)) {

                if ($needRewrite) {
                    Schema::disableForeignKeyConstraints();
                    Size::query()->truncate();
                    Schema::enableForeignKeyConstraints();

                    $materials = Material::query()->get();
                    foreach ($materials as $material){
                        $material->deleted_at = Carbon::now();
                        $material->save();
                    }
                }


                if (is_null($sheetId))
                    throw new HttpException(404, "Идентификатор таблицы или название листа не верные");

                try {
                    $client->fetchAccessTokenWithAuthCode($code);
                    $service = new \Google\Service\Sheets($client);
                    $sheets = new RSheets();
                    $sheets->setService($service);

                    $sheetList = $sheets
                        ->spreadsheet($sheetId)
                        ->sheetList();
                    //->sheet($sheetTitle)
                    //->all();

                    $sheetList = array_values($sheetList);

                    foreach ($sheetList as $sheet) {
                        $values = $sheets
                            ->spreadsheet($sheetId)
                            ->sheet($sheet)
                            ->all();

                        switch ($sheet) {
                            case "Размеры":

                                for ($i = 0; $i < count($values); $i++)
                                    $this->importSizeLoopsRow($values[$i], $i, "sizes",true);
                                break;
                            case "Петли":
                                for ($i = 0; $i < count($values); $i++)
                                    $this->importSizeLoopsRow($values[$i], $i, "loops", true);
                                break;
                            case "Цвет":
                                for ($i = 0; $i < count($values); $i++)
                                    $this->importColorsRow($values[$i], $i, true);
                                break;
                            case "Толщина":
                                for ($i = 0; $i < count($values); $i++)
                                    $this->importDepthRow($values[$i], $i , true);
                                break;
                        }

                    }


                } catch (Exception $exception) {

                    return view("error", [
                        "message" => "Неверный идентификатор листа или название листа"
                    ]);
                }

                if ($usePriceKoef)
                    $this->importRecountPrice();

                return view("success");
                // Log::info(print_r($result,true));
            }
        }

        if ($part == "handles") {
            dd("Test");
        }

        return response()->noContent();

    }

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {

        try {

            $user = Socialite::driver('google')->user();

            $finduser = User::where('google_id', $user->id)->first();

            if ($finduser) {

                Auth::login($finduser);

                return redirect()->intended('/');

            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => 'password'// you can change auto generate password here and send it via email but you need to add checking that the user need to change the password for security reasons
                ]);

                Auth::login($newUser);

                return redirect()->intended('/');
            }

        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }
}
