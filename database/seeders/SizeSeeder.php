<?php

namespace Database\Seeders;

use App\Models\Material;
use App\Models\Size;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @throws \Exception
     */
    public function run(): void
    {

        $widthList = [800, 900, 1000];
        $heightList = [2100, 2300, 2500, 2700, 2800, 3000, 3500, 4000];

        $materials = Material::query()->get();

        foreach ($materials as $material)
            foreach ($heightList as $height)
                foreach ($widthList as $width)
                    Size::factory()->create([
                        'material_id' => $material,
                        'width' => $width,
                        'height' => $height,
                        "type"=>"sizes"
                    ]);


        foreach ($materials as $material)
            foreach ($heightList as $height)
                foreach ($widthList as $width)
                    Size::factory()->create([
                        'material_id' => $material,
                        'width' => $width,
                        'height' => $height,
                        "type"=>"loops",
                        "value"=>random_int(2,4)
                    ]);


        $depth = [45, 57];

        $colors = ["Gold","Black","Silver","RAL"];

        foreach ($depth as $d)
            foreach ($heightList as $height)
                foreach ($widthList as $width)
                    Size::factory()->create([
                        'material_id' => null,
                        'width' => $width,
                        'height' => $height,
                        "type"=>"depth",
                        "value"=>$d
                    ]);

        foreach ($colors as $color)
            foreach ($heightList as $height)
                foreach ($widthList as $width)
                    Size::factory()->create([
                        'material_id' => null,
                        'width' => $width,
                        'height' => $height,
                        "type"=>"colors",
                        "value"=>$color
                    ]);

    }
}
