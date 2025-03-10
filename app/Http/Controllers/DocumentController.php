<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DocumentController extends Controller
{
    private $configPath;

    public function __construct()
    {
        $this->configPath = base_path('seller-config.json');
    }

    // Получить текущий конфиг
    public function getConfig()
    {
        if (!File::exists($this->configPath)) {
            return response()->json(['error' => 'Config file not found'], 404);
        }

        $config = json_decode(File::get($this->configPath), true);
        return response()->json($config);
    }

    // Обновить конфиг полностью или частично
    public function updateConfig(Request $request)
    {
        if (!File::exists($this->configPath)) {
            return response()->json(['error' => 'Config file not found'], 404);
        }

        $config = json_decode(File::get($this->configPath), true);

        // Обновляем только переданные ключи
        $updatedData = $request->all();
        $this->arrayMergeRecursive($config, $updatedData);

        File::put($this->configPath, json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ));

        return response()->json(['message' => 'Config updated successfully', 'config' => $config]);
    }

    // Рекурсивное обновление массива
    private function arrayMergeRecursive(&$original, $updates)
    {
        foreach ($updates as $key => $value) {
            if (is_array($value) && isset($original[$key]) && is_array($original[$key])) {
                $this->arrayMergeRecursive($original[$key], $value);
            } else {
                $original[$key] = $value;
            }
        }
    }
}
