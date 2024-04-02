<?php

namespace Database\Seeders;

use App\Models\Handle;
use Illuminate\Database\Seeder;

class HandleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Handle::factory()->count(5)->create();
    }
}
