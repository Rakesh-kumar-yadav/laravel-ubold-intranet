<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@superadmin.com',
            'fullname' => '',
            'birth' => date_create('01-01-1990'),
            'title' => '',
            'rank' => '',
            'contact_number' => '',
            'extension_number' => '',
            'mobile_number' => '',
            'photo' => 'assets/images/users/avatar.png',
            'password' => bcrypt('password123')
        ]);
        $user->assignRole('Super Admin');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'fullname' => '',
            'birth' => date_create('01-01-1990'),
            'title' => '',
            'rank' => '',
            'contact_number' => '',
            'extension_number' => '',
            'mobile_number' => '',
            'photo' => 'assets/images/users/avatar.png',
            'password' => bcrypt('password123')
        ]);
        $user->assignRole('Admin');

    }
}
