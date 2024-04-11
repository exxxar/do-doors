<?php

namespace Database\Seeders;

use App\Models\Handle;
use App\Models\Material;
use Illuminate\Database\Seeder;

class MaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            "Под покраску",
            "Стекло крашенное",
            "Зеркало",
            "Стекло цветное(Лакобель)",
            "Шпон",
            "Мультишпон",
            "Натуральный шпон",
            "Эмаль",
            "Стекло",
            "АКВА",
            "ЕГГЕР",
        ];

        foreach ($materials as $material)
            Material::factory()->create([
                'title' => $material
            ]);


    }
}
