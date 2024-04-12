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
            'price'=>1000,
        ]);

        DoorVariant::query()->create([
            'title'=>'Короб',
            'price'=>2000,
        ]);

        DoorVariant::query()->create([
            'title'=>'Дверь Magic',
            'price'=>3000,
        ]);

        DoorVariant::query()->create([
            'title'=>'Полотно',
            'price'=>4000,
        ]);
    }
}
