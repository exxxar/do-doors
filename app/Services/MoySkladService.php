<?php

namespace App\Services;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoySkladService
{

    protected string $baseUrl = 'https://api.moysklad.ru/api/remap/1.2';
    protected string $token;
    protected string $credentials;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->credentials = base64_encode(env("MOYSKLAD_LOGIN").":".env("MOYSKLAD_PASSWORD")); // Логин:пароль в base64

        $this->token = $this->getNewToken();
    }

    /**
     * Отправка GET-запроса
     */
    public function get(string $endpoint, array $params = [])
    {
        $response = Http::withHeaders($this->headers())
            ->get($this->baseUrl . $endpoint, $params);

        return $this->handleResponse($response);
    }

    /**
     * Отправка POST-запроса
     */
    public function post(string $endpoint, array $data = [])
    {
        $response = Http::withHeaders($this->headers())
            ->post($this->baseUrl . $endpoint, $data);

        return $this->handleResponse($response);
    }

    /**
     * Формирование заголовков
     */
    protected function headers(): array
    {
        return [
            'Authorization' => 'Bearer ' . $this->token,
            'Accept' => 'application/json;charset=utf-8',
            'Accept-Encoding' => 'gzip',
            'Content-Type' => 'application/json',
        ];
    }

    public function getNewToken()
    {
        $url = 'https://api.moysklad.ru/api/remap/1.2/security/token';
        $headers = [
            'Authorization' => 'Basic ' . $this->credentials,
            'Accept-Encoding' => 'gzip',
        ];

        $response = Http::withHeaders($headers)->post($url);

        // Обработка ответа
        if ($response->successful()) {
            $data = $response->json();
            // Сохраните новый токен в настройках, например, в БД или .env (по желанию)
            return $data['access_token']; // Вернем токен для дальнейшего использования
        }

        // Логируем ошибку, если запрос не успешен
        Log::error('Ошибка получения токена МойСклад: ' . $response->body());
        throw new \Exception("Ошибка при получении токена: " . $response->body());
    }

    /**
     * Обработка ответа
     */
    protected function handleResponse($response)
    {
        if ($response->successful()) {
            return $response->json();
        }

        // Можно выбрасывать исключение или логировать ошибку
        throw new \Exception("Ошибка при запросе к МойСклад: " . $response->body());
    }

    // Пример метода: получение всех товаров
    public function getProducts(array $params = [])
    {
        return $this->get('/entity/product', $params);
    }

    public function getServices(array $params = [])
    {
        return $this->get('/entity/service', $params);
    }

    public function getClients(array $params = [])
    {
        return $this->get('/entity/counterparty', $params);
    }



    public function getProductsByGroupId($id)
    {
        return $this->get('/entity/productfolder', [
            "id"=>$id
        ]);
    }


    // Пример метода: создание товара
    public function createProduct(array $data)
    {
        return $this->post('/entity/product', $data);
    }
}
