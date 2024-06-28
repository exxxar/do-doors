<?php

namespace Database\Seeders;

use App\Models\DoorVariant;
use App\Models\Handle;
use App\Models\Hinge;
use Illuminate\Database\Seeder;

class DoorVariantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        DoorVariant::query()->create([
            'title'=>'Комплект двери скрытого монтажа',
             'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
        ]);

        DoorVariant::query()->create([
            'title'=>'Короб',
             'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
        ]);

        DoorVariant::query()->create([
            'title'=>'Дверь Magic',
             'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
        ]);

        DoorVariant::query()->create([
            'title'=>'Полотно',
             'price'=>(object)[
                    "wholesale" => 100,
                    "dealer" => 200,
                    "retail" => 300,
                    "cost" => 400,
                ],
        ]);
    }
}
