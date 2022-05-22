<?php

namespace Database\Seeders;

use App\Models\CompanySetting;
use Illuminate\Database\Seeder;

class CompanySettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new CompanySetting();
        $setting->company_name = 'Haru Company';
        $setting->company_email = 'haru@gmail.com';
        $setting->company_phone = '09450052671';
        $setting->company_address = 'Yangon';
        $setting->office_start_time = '9:00:00';
        $setting->office_end_time = '18:00:00';
        $setting->break_start_time = '12:00:00';
        $setting->break_end_time = '13:00:00';
        $setting->save();
    }
}
