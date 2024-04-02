<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $widthList = [700, 800, 900, 1000];
        $heightList = [2100, 2300, 2500, 2700, 2800, 2900, 3000, 3100, 3200, 3300];

        $materials = Material::query()->get();

        foreach ($materials as $material)
            foreach ($heightList as $height)
                foreach ($widthList as $width)
                    Size::factory()->create([
                        'material_id' => $material,
                        'width' => $width,
                        'height' => $height,
                    ]);
    }
}
