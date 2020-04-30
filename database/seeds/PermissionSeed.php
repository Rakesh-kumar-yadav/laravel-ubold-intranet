<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call('cache:clear');
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        
        Permission::create(['name' => 'users_manage']);
        Permission::create(['name' => 'companies_manage']);
        Permission::create(['name' => 'departments_manage']);
        Permission::create(['name' => 'usersettings_manage']);
        Permission::create(['name' => 'settings_manage']);
        Permission::create(['name' => 'documents_manage']);
        Permission::create(['name' => 'users']);
    }
}
