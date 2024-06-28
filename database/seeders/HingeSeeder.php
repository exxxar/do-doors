<?php

namespace Database\Seeders;

use App\Models\Handle;
use App\Models\Hinge;
use Illuminate\Database\Seeder;

class HingeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Hinge::query()->create([
            'title'=>'Стандарт',
             'price'=>(object)[
                    "wholesale" => 0,
                    "dealer" => 0,
                    "retail" => 0,
                    "cost" => 0,
                ],
        ]);

        Hinge::query()->create([
            'title'=>'AGB',
             'price'=>(object)[
                    "wholesale" => 800,
                    "dealer" => 800,
                    "retail" => 800,
                    "cost" => 800,
                ],
        ]);


    }
}
