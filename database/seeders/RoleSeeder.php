<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $client = new Role();
        $client->name = 'Клиент';
        $client->slug = 'client';
        $client->save();

        $manager = new Role();
        $manager->name = 'Менеджер';
        $manager->slug = 'manager';
        $manager->save();

        $admin = new Role();
        $admin->name = 'Администратор';
        $admin->slug = 'administrator';
        $admin->save();

        $manager = new Role();
        $manager->name = 'Директор';
        $manager->slug = 'director';
        $manager->save();

        $developer = new Role();
        $developer->name = 'Разработчик';
        $developer->slug = 'developer';
        $developer->save();


        $dealer = new Role();
        $dealer->name = 'Дилер';
        $dealer->slug = 'dealer';
        $dealer->save();

        $distributor = new Role();
        $distributor->name = 'Дистрибьютор';
        $distributor->slug = 'distributor';
        $distributor->save();
    }
}
