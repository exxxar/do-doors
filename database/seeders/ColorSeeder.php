<?php

namespace Database\Seeders;

use App\Models\Color;
use App\Models\Handle;
use App\Models\Hinge;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ["side_finish", "box_and_frame","seal","fittings"];



        foreach ($types as $type)
        {
            Color::query()->create([
                'title'=>'Серебряный',
                'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
                'type'=>$type,
                'code'=> "#C0C0C0"
            ]);

            Color::query()->create([
                'title'=>'Золотой',
                 'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
                'type'=>$type,
                'code'=> "#ffd700"
            ]);

            Color::query()->create([
                'title'=>'Черный',
                 'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
                'type'=>$type,
                'code'=> "#000000"
            ]);

            Color::query()->create([
                'title'=>'RAL',
                 'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
                'type'=>$type,
                'code'=> null
            ]);

        }





    }
}
