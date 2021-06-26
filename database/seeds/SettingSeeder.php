<?php

use Illuminate\Database\Seeder;
use App\setting;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        setting::create([
            'setting' => 'Capital',
            'value'   => 0,
        ]);

        setting::create([
            'setting' => 'Fiscal_Year',
            'value'   => date('Y-m-d h:i:s')
        ]);
    }
}
