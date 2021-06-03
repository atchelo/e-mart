<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ThemeSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('theme_settings')->delete();
        
        \DB::table('theme_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'key' => 'default',
                'theme_name' => '',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
        ));
        
        
    }
}