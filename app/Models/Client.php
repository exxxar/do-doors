<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'phone',
        'email',
        'fact_address',
        'comment',
        'user_id',
        'title',
        'law_address',
        'inn',
        'kpp',
        'ogrn',
        'okpo',
        'requisites',
        'fio'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'requisites' => 'array',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    protected $with = ["user"];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getBueryData()
    {
        $main_requisites = [];
        foreach ($this->requisites ?? [] as $item) {
            if ($item["is_main"]) {
                $main_requisites = $item;
            }
        }

        $buyerData = [
            'buyer_title' => $this->fio ?? '-',
            'buyer_phone' => $this->phone ?? '-',
            'buyer_inn' => $this->inn ?? '-',
            'buyer_kpp' => $this->kpp ?? '-',
            'buyer_ogrn' => $this->ogrn ?? '-',
            'buyer_email' => $this->email ?? '-',
            'buyer_representative' => null,
            'buyer_bank_name' => $main_requisites["bank"] ?? '-',
            'buyer_bank_bic' => $main_requisites["bik"] ?? '-',
            'buyer_legal_address' => $this->law_address ?? '-',
            'buyer_correspondent_account' => $main_requisites["correspondent_account"] ?? '-',
            'buyer_checking_account' => $main_requisites["checking_account"] ?? '-',
            'buyer_settlement_account' => null,
        ];

        return $buyerData;
    }

    public function getBitrix24DealData()
    {

        $fio = explode(" ", $this->fio, 3);

        $fname = $fio[0] ?? '';
        $sname = $fio[1] ?? '';
        $tname = $fio[2] ?? '';

        $leadData = [
            'TITLE' => $this->fio,
            'NAME' => $fname,

            'SECOND_NAME' => $sname,
            'LAST_NAME' => $tname,
            'COMMENTS' => 'Лид из конструктора',
            'SOURCE_ID' => 'OTHER',
            'SOURCE_DESCRIPTION' => env("SOURCE_DESCRIPTION"),
            'STATUS_ID' => 'NEW',//NEW, IN_PROCESS, PROCESSED, JUNK, CONVERTED
            'PHONE' => [['VALUE' => $this->phone, 'VALUE_TYPE' => 'WORK']],
            'EMAIL' => [['VALUE' => $this->email, 'VALUE_TYPE' => 'WORK']]
        ];

        return $leadData;
    }

    public function getBitrix24LeadData()
    {

        $fio = explode(" ", $this->fio, 3);

        $fname = $fio[0] ?? '';
        $sname = $fio[1] ?? '';
        $tname = $fio[2] ?? '';

        $leadData = [
            'TITLE' => $this->fio,
            'NAME' => $fname,
            'SECOND_NAME' => $sname,
            'LAST_NAME' => $tname,
            'COMMENTS' => 'Лид из конструктора',
            'SOURCE_ID' => 'OTHER',
            'SOURCE_DESCRIPTION' => env("SOURCE_DESCRIPTION"),
            'STATUS_ID' => 'NEW',//NEW, IN_PROCESS, PROCESSED, JUNK, CONVERTED
            'PHONE' => [['VALUE' => $this->phone, 'VALUE_TYPE' => 'WORK']],
            'EMAIL' => [['VALUE' => $this->email, 'VALUE_TYPE' => 'WORK']]
        ];

        return $leadData;
    }

    public function getFName()
    {
        $fio = explode(" ", $this->fio, 3);
        return $fio[0] ?? null;
    }

    public function getSName()
    {
        $fio = explode(" ", $this->fio, 3);
        return $fio[1] ?? null;
    }

    public function getLName()
    {
        $fio = explode(" ", $this->fio, 3);
        return $fio[2] ?? null;
    }

    public function getInitials()
    {

        $candidat_fio = $this->fio;
        if ($this->status == 'individual') {
            $candidat_fio = $this->title;
        }
        if (is_null($candidat_fio) && $candidat_fio == '') {
            return null;
        }
        $fio = explode(" ", $candidat_fio, 3);

        return $fio[0] . " " . mb_substr($fio[1], 0, 1) . "." . mb_substr($fio[2], 0, 1) . ".";
    }

    public function getShortClientStatus()
    {
        $statusClient = '';
        switch ($this->status) {
            case 'individual':
                $statusClient = "ФЛ";
                break;
            case 'sole_proprietor':
                $statusClient = "ИП";
                break;
            case 'legal_entity':
                $statusClient = "ООО";
                break;
        }
        return $statusClient;
    }

}
