<?php

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = Setting::create([
            'footername' => '2019 © Intranet',
            'our_goal' => '',
            'hr_link' => '',
            'contact' => '',
            'title' => 'Intranet',
        ]);
    }
}
