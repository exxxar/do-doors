<?php

namespace App\Http\Controllers;

use App\Classes\DocumentLogic;
use Carbon\Carbon;
use Illuminate\Support\Str;
use PhpOffice\PhpWord\TemplateProcessor;


use Illuminate\Support\Facades\Storage;


trait Utility
{


    /**
     * Формирует DOCX-документ на основе шаблона и данных заказа
     *
     * @param string $templateName Имя шаблонного файла (например, "договор с ООО.docx")
     * @param array $data Данные для заполнения документа:
     * - name: имя клиента
     * - email: email клиента
     * - phone: телефон клиента
     * - info: дополнительная информация
     * - total_price: общая сумма заказа
     * - total_count: количество товаров
     * - current_payed: оплаченная сумма
     * - payed_percent: процент предоплаты
     * - passport: паспортные данные
     * - passport_issued: кем выдан паспорт
     * - client_id: ID клиента
     * - statusClient: статус клиента (например, "ФЛ", "ИП", "ООО")
     * - workDays: количество рабочих дней
     * - buyerData: массив с данными покупателя (банковские реквизиты и т.п.)
     * @return string Путь к созданному файлу
     */
    function generateContractDocument(string $templateName, array $data): string
    {
        // Путь к хранилищу
        $path = storage_path('app');

        // Сгенерированное имя файла
        $timeFragment = Carbon::now()->format('Y-m-d H-i-s');
        $newName = "/договор с клиентом №{$data['client_id']} {$data['statusClient']} от {$timeFragment}.docx";

        // Полный путь к файлу
        $filePath = $path . $newName;

        // Проверка существования шаблона
        if (!file_exists("$path/$templateName")) {
            throw new \Exception("Шаблонный файл не найден: $templateName");
        }

        // Создаем процессор шаблона
        $templateProcessor = new TemplateProcessor("$path/$templateName");

        // Преобразуем число дней в текстовое представление
        $workDaysString = $data['workDays'] . ' (' . (new \MessageFormatter('ru-RU', '{n, spellout}'))->format(['n' => $data['workDays']]) . ')';

        // Заполняем шаблон данными
        $templateProcessor->setValue('date_doc', Carbon::now()->format('d-m-Y'));
        $templateProcessor->setValue('numb_doc', $data['order_id']);
        $templateProcessor->setValue('title', $data['name']);
        $templateProcessor->setValue('member', $data['fio'] ?? '-');
        $templateProcessor->setValue('fio', $data['famInitial'] ?? '-');
        $templateProcessor->setValue('email', $data['email']);
        $templateProcessor->setValue('phone', $data['phone']);
        $templateProcessor->setValue('fact_address', $data['fact_address'] ?? '-');
        $templateProcessor->setValue('law_address', $data['law_address'] ?? '-');
        $templateProcessor->setValue('inn', $data['inn'] ?? '-');
        $templateProcessor->setValue('ogrn', $data['ogrn'] ?? '-');
        $templateProcessor->setValue('kpp', $data['kpp'] ?? '-');
        $templateProcessor->setValue('okpo', $data['okpo'] ?? '-');
        $templateProcessor->setValue('order_id', $data['order_id']);
        $templateProcessor->setValue('info', $data['info']);
        $templateProcessor->setValue('total_price', $data['total_price']);
        $templateProcessor->setValue('total_count', $data['total_count']);
        $templateProcessor->setValue('current_payed', $data['current_payed']);
        $templateProcessor->setValue('payed_percent', $data['payed_percent']);
        $templateProcessor->setValue('last_payment', $data['total_price'] - $data['current_payed']);
        $templateProcessor->setValue('delivery_terms', $data['delivery_terms'] ?? '-');
        $templateProcessor->setValue('work_days', $workDaysString);
        $templateProcessor->setValue('bik', $data['buyerData']['buyer_bank_bic'] ?? '-');
        $templateProcessor->setValue('ksch', $data['buyerData']['buyer_correspondent_account'] ?? '-');
        $templateProcessor->setValue('rsch', $data['buyerData']['buyer_checking_account'] ?? '-');
        $templateProcessor->setValue('bank_name', $data['buyerData']['buyer_bank_name'] ?? '-');
        $templateProcessor->setValue('passport', $data['passport']);
        $templateProcessor->setValue('passport_issued', $data['passport_issued']);

        ///delivery и install поля
        $templateProcessor->setValue('delivery', $data["delivery"] == 0 ? "входит" : "не входит");
        $templateProcessor->setValue('install', $data["install"] ? "входит" : "не входит");

        // Добавляем параметры продавца
        $doc = new DocumentLogic();
        foreach ($doc->getAllSellerParameters($data['workWithNds']) as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

        // Сохраняем файл
        $templateProcessor->saveAs($filePath);

        return $filePath;
    }

    protected function uploadPhotos(array $uploadedFiles = null, $needOriginalName = false): array
    {
        if (is_null($uploadedFiles))
            return [];

        $path = public_path('images/');

        $photos = [];
        foreach ($uploadedFiles as $key => $file) {
            $ext = $file->getClientOriginalExtension();

            $imageName = Str::uuid() . "." . $ext;

            $file->move($path, $imageName);
            $photos[] = $needOriginalName ? (object)[
                "current" => $imageName,
                "original" => $file->getClientOriginalName()
            ] : $imageName;
        }

        return $photos;
    }

    protected function uploadDocuments(array $uploadedFiles = null, $needOriginalName = false): array
    {
        if (is_null($uploadedFiles))
            return [];

        $path = storage_path('app/public/documents/');

        $files = [];
        foreach ($uploadedFiles as $key => $file) {
            $ext = $file->getClientOriginalExtension();

            $fileName = Str::uuid() . "." . $ext;

            $file->move($path, $fileName);
            $files[] = $needOriginalName ? (object)[
                "current" => $fileName,
                "original" => $file->getClientOriginalName()
            ] : $fileName;
        }

        return $files;
    }
}
