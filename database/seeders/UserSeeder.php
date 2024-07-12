<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $administrator = Role::where('slug','administrator')->first();

        $managerCalc = Permission::where('slug','manage-calc')->first();
        $managerUsers = Permission::where('slug','manage-users')->first();
        $managerRolesAndPermissions = Permission::where('slug','manage-roles-and-permissions')->first();
        $managerClients = Permission::where('slug','manage-clients')->first();
        $managerMaterials = Permission::where('slug','manage-materials')->first();
        $managerSizes = Permission::where('slug','manage-sizes')->first();
        $managerHandles = Permission::where('slug','manage-handles')->first();
        $managerOrders = Permission::where('slug','manage-orders')->first();
        $managerHinges = Permission::where('slug','manage-hinges')->first();
        $managerDoorVariants = Permission::where('slug','manage-door-variants')->first();
        $managerColor= Permission::where('slug','manage-colors')->first();
        $managerPromoCodes= Permission::where('slug','manage-promo-codes')->first();
        $managerRoles = Permission::where('slug','manage-roles')->first();
        $managerPermissions = Permission::where('slug','manage-permissions')->first();
        $managerViewsAdminmenu= Permission::where('slug','manage-views-adminmenu')->first();
        $managerServices = Permission::where('slug','manage-services')->first();

        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('password');
        $user->save();

        $user->roles()->attach($administrator);
        $user->permissions()->attach($managerCalc);
        $user->permissions()->attach($managerUsers);
        $user->permissions()->attach($managerRolesAndPermissions);
        $user->permissions()->attach($managerClients);
        $user->permissions()->attach($managerMaterials);
        $user->permissions()->attach($managerSizes);
        $user->permissions()->attach($managerHandles);
        $user->permissions()->attach($managerOrders);
        $user->permissions()->attach($managerHinges);
        $user->permissions()->attach($managerDoorVariants);
        $user->permissions()->attach($managerColor);
        $user->permissions()->attach($managerPromoCodes);
        $user->permissions()->attach($managerPermissions);
        $user->permissions()->attach($managerRoles);
        $user->permissions()->attach($managerViewsAdminmenu);
        $user->permissions()->attach($managerServices);
        $user->save();

    }
}
