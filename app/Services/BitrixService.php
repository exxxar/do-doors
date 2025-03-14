<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class BitrixService
{
    protected $webhookUrl;

    public function __construct()
    {
        $this->webhookUrl = env('BITRIX_WEBHOOK_URL');
    }

    // Добавление товара
    public function addProduct(array $productData)
    {
        return $this->request('crm.product.add', ['fields' => $productData]);
    }

    public function getLeadProducts($leadId)
    {
        return $this->request("crm.lead.productrows.get", [
            'ID' => $leadId,
        ]);
    }

    public function getFolder($folderId)
    {
        return $this->request('disk.folder.get', [
            'id' => $folderId
        ]);
    }

    public function listFolders()
    {
        return $this->request('disk.storage.getlist', [

        ]);
    }

    public function uploadDocument($folderId, $filePath, $fileName)
    {

        return $this->request('disk.folder.uploadfile', [
            'id' => $folderId, // ID папки в "Диске"
            'fileContent' => $filePath,
            'data' => [
                'NAME' => $fileName
            ],
            'generateUniqueName' => 'Y'
        ]);
    }


    // Добавление товара к лиду
    public function addProductToLead($leadId, array $productRows)
    {
        return $this->request("crm.lead.productrows.set", [
            'id' => $leadId,
            'rows' => $productRows
        ]);
    }

    public function getLeadDealFields()
    {
        return $this->request("crm.deal.userfield.list", [
            "select"=>  ["ID", "FIELD_NAME", "USER_TYPE_ID", "EDIT_FORM_LABEL", "LIST_COLUMN_LABEL","LIST_FILTER_LABEL"]
        ]);
    }

    public function getLeadFields()
    {
        return $this->request("crm.lead.fields", [
            "select"=>["ID", "FIELD_NAME", "USER_TYPE_ID", "EDIT_FORM_LABEL"]
        ]);
    }

    // Добавление документа к лиду
    public function addDocumentToLead($leadId, $fName, $fPath, $param = null)
    {


        return $this->request('crm.lead.update', [
            'id' => $leadId,
            'fields' => [
                "$param" => [
                    "fileData" => [$fName, $fPath]
                ]
            ]
        ]);

    }

    // Добавление документа к лиду
    public function addDocumentsToLead($leadId, array $files, $param = null)
    {

     //   $param = is_null($param) ? env('DOCUMENT_FILED_CODE_SPECIFICATION') : null;

        $documents = [];

        foreach ($files as $file) {
            $documents[] = [
                "fileData" => [$file["name"], $file["path"]]
            ];
        }

        return $this->request('crm.lead.update', [
            'id' => $leadId,
            'fields' => [
                "$param" => $documents // UF_CRM_XXXXXX - поле "Файл"
            ]
        ]);

    }

    // Создание лида
    public function getLead(int $id)
    {
        return $this->request('crm.lead.get', ['id' => $id]);
    }


    // Создание лида
    public function createLead(array $leadData)
    {
        return $this->request('crm.lead.add', ['fields' => $leadData]);
    }


    // Удаление товара
    public function deleteProduct($productId)
    {
        return $this->request('crm.product.delete', ['id' => $productId]);
    }

    // Удаление документа у лида
    public function deleteDocumentFromLead($leadId)
    {
        // Получаем лид
        $lead = $this->request('crm.lead.get', ['id' => $leadId]);

        if (!isset($lead['result']['UF_CRM_12345'])) { // UF_CRM_12345 - поле с файлом
            return ['error' => 'Документ не найден у лида'];
        }

        $fileId = $lead['result']['UF_CRM_12345']; // ID файла
        return $this->request('disk.file.delete', ['id' => $fileId]);
    }

    // Получение списка лидов
    public function getLeads(array $filter = [], array $select = ['ID', 'TITLE', 'PHONE', 'STATUS_ID'])
    {
        $select[] = env("DOCUMENT_FILED_CODE");
        return $this->request('crm.lead.list', [
            'order' => ['ID' => 'DESC'],
            'filter' => $filter,
            'select' => $select
        ]);
    }

    // Получение списка товаров
    public function getProducts(array $filter = [], array $select = ['ID', 'NAME', 'PRICE'])
    {
        return $this->request('crm.product.list', [
            'order' => ['ID' => 'DESC'],
            'filter' => $filter,
            'select' => $select
        ]);
    }

    // Обновление документа в лиде
    public function updateDocumentInLead($leadId, string $newFilePath)
    {
        $this->deleteDocumentFromLead($leadId);
        return $this->addDocumentToLead($leadId, $newFilePath);
    }

    // Редактирование лида
    public function updateLead($leadId, array $updateData)
    {
        return $this->request('crm.lead.update', [
            'id' => $leadId,
            'fields' => $updateData
        ]);
    }

    // Вспомогательный метод для запросов к API
    protected function request($method, $params = [])
    {
        $response = Http::post("{$this->webhookUrl}{$method}.json", $params);

        return $response->json();
    }
}
