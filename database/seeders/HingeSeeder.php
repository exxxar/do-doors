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
            'price'=>1000,
        ]);

        Hinge::query()->create([
            'title'=>'AGB',
            'price'=>2000,
        ]);


    }
}
