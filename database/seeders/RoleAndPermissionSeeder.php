<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;



class RoleAndPermissionSeeder extends Seeder
{

    public function run()
    {

        $permissionsAdmin = array_merge([
            'users.index',
            'users.create',
            'users.store',
            'users.edit',
            'users.update',
            'users.destroy',
            'users.getAll',
            'products.index',
            'products.show',
            'products.store',
            'products.search',
            'products.update',
            'products.destroy',
            'categories.index',
            'categories.getCategories',
            'categories.create',
            'categories.store',
            'categories.edit',
            'categories.update',
            'categories.destroy',
        ]);


        $admin = Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);

        foreach ($permissionsAdmin as $permission){
            $permission = Permission::create(['name' => $permission]);
            $admin->givePermissionTo($permission);
        }
    }
}
