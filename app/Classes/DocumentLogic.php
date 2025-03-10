<?php

namespace App\Classes;

use Illuminate\Support\Facades\File;

class DocumentLogic
{
    private $json;

    public function __construct()
    {
        $configPath = base_path('seller-config.json');

        $this->json = File::get($configPath);
    }

    function getAllSellerParameters($type = 0)
    {
        $data = json_decode($this->json, true);

        if (!isset($data['seller'])) {
            return null;
        }

        $sellerData = json_decode($data['seller'], true);

        $sellerData = $type == 0 ? $sellerData["individual_entrepreneur"] : $sellerData["limited_liability_company"];

        $legalAddress = $sellerData['legal_address'] ?? null;
        $addressString = ($legalAddress['postal_code'] ?? '') . ', ' .
            ($legalAddress['region'] ?? '') . ', ' .
            ($legalAddress['city'] ?? '') . ', ' .
            ($legalAddress['street'] ?? '') . ', ' .
            ($legalAddress['building'] ?? '');

        return [
            'seller_title' => $sellerData['title'] ?? null,
            'seller_inn' => explode('/', $sellerData['INN_KPP'] ?? '')[0] ?? null,
            'seller_kpp' => explode('/', $sellerData['INN_KPP'] ?? '')[1] ?? null,
            'seller_ogrn' => $sellerData['OGRN'] ?? null,
            'seller_email' => $sellerData['email'] ?? null,
            'seller_phone' => $sellerData['phone'] ?? null,
            'seller_representative' => $sellerData['supplier_representative']['full_name'] ?? null,
            'seller_bank_name' => $sellerData['bank']['name'] ?? null,
            'seller_bank_bic' => $sellerData['bank']['BIC'] ?? null,
            'seller_correspondent_account' => $sellerData['bank']['correspondent_account'] ?? null,
            'seller_checking_account' => $sellerData['bank']['checking_account'] ?? null,
            'seller_legal_address' => $addressString,
        ];
    }

    function getSellerParameter($key, $default = '')
    {
        $data = json_decode($this->json, true);

        if (!isset($data['seller'])) {
            return null;
        }

        $sellerData = json_decode($data['seller'], true);

        $mapping = [
            'seller_company' => $sellerData['company'] ?? null,
            'seller_inn' => explode('/', $sellerData['INN_KPP'] ?? '')[0] ?? null,
            'seller_kpp' => explode('/', $sellerData['INN_KPP'] ?? '')[1] ?? null,
            'seller_ogrn' => $sellerData['OGRN'] ?? null,
            'seller_email' => $sellerData['email'] ?? null,
            'seller_representative' => $sellerData['supplier_representative']['full_name'] ?? null,
            'seller_bank_name' => $sellerData['bank']['name'] ?? null,
            'seller_bank_bic' => $sellerData['bank']['BIC'] ?? null,
            'seller_legal_address' => $sellerData['legal_address'] ?? null,
        ];

        return $mapping[$key] ?? $default;
    }

}
