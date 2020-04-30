<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Super Admin']);
        $role->givePermissionTo('users_manage');
        $role->givePermissionTo('companies_manage');
        $role->givePermissionTo('departments_manage');
        $role->givePermissionTo('usersettings_manage');
        $role->givePermissionTo('settings_manage');
        $role->givePermissionTo('documents_manage');
        $role->givePermissionTo('users');

        $role = Role::create(['name' => 'Admin']);
        $role->givePermissionTo('users');
        $role->givePermissionTo('usersettings_manage');
        $role->givePermissionTo('documents_manage');

        $role = Role::create(['name' => 'User']);
        $role->givePermissionTo('users');

    }
}
