<?php

namespace Database\Seeders;

use App\Models\GeneralSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        GeneralSetting::truncate();

        GeneralSetting::insert([
            [
                'notification_emails' => 'yanz.sytian@gmail.com,kenneth@sytian-productions.com',
                'maintenance_mode' => 0
            ]
        ]);
    }
}
