<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permission = new Permission();
        $permission->name = 'Работа с пользователями';
        $permission->slug = 'manage-users';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с ролями';
        $permission->slug = 'manage-roles';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с разрешениями';
        $permission->slug = 'manage-permissions';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с ролями и разрешениями';
        $permission->slug = 'manage-roles-and-permissions';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с клиентами';
        $permission->slug = 'manage-clients';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с калькулятором';
        $permission->slug = 'manage-calc';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с материалами';
        $permission->slug = 'manage-materials';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с размерами';
        $permission->slug = 'manage-sizes';
        $permission->save();


        $permission = new Permission();
        $permission->name = 'Работа с ручками';
        $permission->slug = 'manage-handles';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с петлями';
        $permission->slug = 'manage-hinges';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с вариантами дверей';
        $permission->slug = 'manage-door-variants';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с цветами';
        $permission->slug = 'manage-colors';
        $permission->save();


        $permission = new Permission();
        $permission->name = 'Работа с заказами';
        $permission->slug = 'manage-orders';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с промокодами';
        $permission->slug = 'manage-promo-codes';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Просмотр административного меню';
        $permission->slug = 'manage-views-adminmenu';
        $permission->save();

        $permission = new Permission();
        $permission->name = 'Работа с сервисами';
        $permission->slug = 'manage-services';
        $permission->save();


    }
}
