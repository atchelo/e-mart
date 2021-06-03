<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AutoDetectGeosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('auto_detect_geos')->delete();
        
        \DB::table('auto_detect_geos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'enabel_multicurrency' => '0',
                'auto_detect' => '0',
                'default_geo_location' => NULL,
                'currency_by_country' => '0',
                'enable_cart_page' => '0',
                'checkout_currency' => '0',
                'created_at' => NULL,
                'updated_at' => '2019-10-21 11:06:26',
            ),
        ));
        
        
    }
}