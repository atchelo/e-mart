<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WidgetsettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('widgetsettings')->delete();
        
        \DB::table('widgetsettings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'category',
                'home' => '1',
                'shop' => '0',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'hotdeals',
                'home' => '1',
                'shop' => '1',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'specialoffer',
                'home' => '1',
                'shop' => '0',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'testimonial',
                'home' => '1',
                'shop' => '0',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'newsletter',
                'home' => '1',
                'shop' => '1',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'slider',
                'home' => '1',
                'shop' => '0',
            ),
        ));
        
        
    }
}