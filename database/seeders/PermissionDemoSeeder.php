<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        //permission super admin
        Permission::create(['name' => 'create data sensitive', 'guard_name' => 'api']);
        Permission::create(['name' => 'read data sensitive', 'guard_name' => 'api']);
        Permission::create(['name' => 'update data sensitive', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete data sensitive', 'guard_name' => 'api']);
        //permission admin
        Permission::create(['name' => 'create data', 'guard_name' => 'api']);
        Permission::create(['name' => 'read data', 'guard_name' => 'api']);
        Permission::create(['name' => 'update data', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete data', 'guard_name' => 'api']);
        //permission student
        Permission::create(['name' => 'create data student', 'guard_name' => 'api']);
        Permission::create(['name' => 'read data student', 'guard_name' => 'api']);
        Permission::create(['name' => 'update data student', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete data student', 'guard_name' => 'api']);
        //permission question maker
        Permission::create(['name' => 'create data question maker', 'guard_name' => 'api']);
        Permission::create(['name' => 'read data question maker', 'guard_name' => 'api']);
        Permission::create(['name' => 'update data question maker', 'guard_name' => 'api']);
        Permission::create(['name' => 'delete data question maker', 'guard_name' => 'api']);

        $superAdmin = Role::create(['name' => 'super admin', 'guard_name' => 'api']);
        $superAdmin->givePermissionTo('create data sensitive');
        $superAdmin->givePermissionTo('read data sensitive');
        $superAdmin->givePermissionTo('update data sensitive');
        $superAdmin->givePermissionTo('delete data sensitive');
        $superAdmin->givePermissionTo('create data');
        $superAdmin->givePermissionTo('read data');
        $superAdmin->givePermissionTo('update data');
        $superAdmin->givePermissionTo('delete data');

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $admin->givePermissionTo('create data');
        $admin->givePermissionTo('read data');
        $admin->givePermissionTo('update data');
        $admin->givePermissionTo('delete data');

        $student = Role::create(['name' => 'student', 'guard_name' => 'api']);
        $admin->givePermissionTo('create data student');
        $admin->givePermissionTo('read data student');
        $admin->givePermissionTo('update data student');
        $admin->givePermissionTo('delete data student');

        $questionMaker = Role::create(['name' => 'question maker', 'guard_name' => 'api']);
        $admin->givePermissionTo('create data question maker');
        $admin->givePermissionTo('read data question maker');
        $admin->givePermissionTo('update data question maker');
        $admin->givePermissionTo('delete data question maker');
    }
}
