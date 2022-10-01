<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

       $permission_edit_company= Permission::create(['name' => 'edit company', 
          'guard_name'=>'api',
        ]);

        $role_admin=Role::create(['name' => 'admin',
        'guard_name'=>'api',
        ]);

        $role_owner=Role::create(['name' => 'owner',
        'guard_name'=>'api',

       ]);

        $role_owner->givePermissionTo($permission_edit_company);

        $role_employee=Role::create(['name' => 'employee',
        'guard_name'=>'api',
       ]);


         //dd(Role::query()->get());

    }
}
