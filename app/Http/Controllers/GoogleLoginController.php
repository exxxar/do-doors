<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Size;
use App\Models\User;
use Exception;
use Google\Client;
use Google\Service\Sheets;
use HttpException;
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

class GoogleLoginController extends Controller
{
    protected $materials = [];

    /**
     * Create a new controller instance.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function onRow($row, $rowIndex)
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

    }

    public function getGoogleLink(Request $request)
    {
        $request->validate([
            "sheet_id" => "required",
            "sheet_title" => "required"
        ]);
        $client = new Client();
        $client->setAuthConfig((array)json_decode(file_get_contents(storage_path("app/credentials.json"))));
        $client->setScopes([Sheets::DRIVE, Sheets::SPREADSHEETS]);
        $client->setClientId(env("GOOGLE_CLIENT_ID"));
        $client->setClientSecret(env("GOOGLE_CLIENT_SECRET"));
        $client->setRedirectUri(env("GOOGLE_REDIRECT"));
        $client->setAccessType("offline");

        Session::remove("sheet_id");
        Session::remove("sheet_title");
        Session::remove("need_rewrite");

        Session::put("sheet_id", $request->sheet_id);
        Session::put("sheet_title", $request->sheet_title);
        Session::put("need_rewrite", ($request->need_rewrite ?? false) == "true");


        return response()->json(["url" => $client->createAuthUrl()]);
    }

    /**
     * @throws \Google\Exception
     * @throws HttpException
     */
    public function serviceCallback(Request $request)
    {

        $code = $request->all()["code"] ?? null;

        $client = new Client();
        $client->setAuthConfig((array)json_decode(file_get_contents(storage_path("app/credentials.json"))));
        $client->setScopes([Sheets::DRIVE, Sheets::SPREADSHEETS]);
        $client->setClientId(env("GOOGLE_CLIENT_ID"));
        $client->setClientSecret(env("GOOGLE_CLIENT_SECRET"));
        $client->setRedirectUri(env("GOOGLE_REDIRECT"));
        $client->setAccessType("offline");


        if (!is_null($code)) {

            $sheetId = Session::get("sheet_id", null);
            $sheetTitle = Session::get("sheet_title", null);
            $needRewrite = Session::get("need_rewrite", false);

            if (is_null($sheetId) || is_null($sheetTitle))
                throw new HttpException("Идентификатор таблицы или название листа не верные", 400);

            try {
                $client->fetchAccessTokenWithAuthCode($code);
                $service = new \Google\Service\Sheets($client);
                $sheets = new RSheets();
                $sheets->setService($service);

                $values = $sheets->spreadsheet($sheetId)
                    ->sheet($sheetTitle)
                    ->all();

                if ($needRewrite) {
                    Schema::disableForeignKeyConstraints();
                    Size::query()->truncate();
                    //Material::query()->truncate();
                    Schema::enableForeignKeyConstraints();
                }

                for ($i = 0; $i < count($values); $i++)
                    $this->onRow($values[$i], $i);
            }catch (Exception $exception){
                return view("error", [
                    "message"=>"Неверный идентификатор листа или название листа"
                ]);
            }


            return view("success");
            // Log::info(print_r($result,true));
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
            dd($user);
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
