<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SpecialOfferWidgetTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('special_offer_widget')->delete();
        
        \DB::table('special_offer_widget')->insert(array (
            0 => 
            array (
                'id' => 1,
                'slide_count' => '3',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}