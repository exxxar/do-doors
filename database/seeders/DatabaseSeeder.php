<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(MaterialSeeder::class);
        $this->call(SizeSeeder::class);
        $this->call(HandleSeeder::class);
        $this->call(HingeSeeder::class);
        $this->call(DoorVariantSeeder::class);
        $this->call(ColorSeeder::class);
    }
}
