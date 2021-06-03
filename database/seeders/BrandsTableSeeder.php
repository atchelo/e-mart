<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('brands')->delete();
        
        \DB::table('brands')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_id' => '["1","2","3","4","5"]',
                'name' => 'Hot foil',
                'image' => '1606197753brand1.png',
                'status' => '1',
                'created_at' => '2020-11-24 11:32:34',
                'updated_at' => '2020-11-24 11:32:34',
                'show_image' => '1',
                'is_requested' => 0,
                'brand_proof' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'category_id' => '["1","2","3","4","5"]',
                'name' => 'Blueline',
                'image' => '1606197771brand3.png',
                'status' => '1',
                'created_at' => '2020-11-24 11:32:51',
                'updated_at' => '2020-11-24 11:32:51',
                'show_image' => '1',
                'is_requested' => 0,
                'brand_proof' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'category_id' => '["1","2","3","4","5"]',
                'name' => 'Your Logo',
                'image' => '1606197795brand5.png',
                'status' => '1',
                'created_at' => '2020-11-24 11:33:15',
                'updated_at' => '2020-11-24 11:33:15',
                'show_image' => '1',
                'is_requested' => 0,
                'brand_proof' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'category_id' => '["1","2","3","4","5"]',
                'name' => 'Cape racer',
                'image' => '1606197814brand6.png',
                'status' => '1',
                'created_at' => '2020-11-24 11:33:34',
                'updated_at' => '2020-11-24 11:33:34',
                'show_image' => '1',
                'is_requested' => 0,
                'brand_proof' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'category_id' => '["2","5"]',
                'name' => 'Market D',
                'image' => '1606209428b-logo3.png',
                'status' => '1',
                'created_at' => '2020-11-24 14:47:08',
                'updated_at' => '2020-11-24 14:47:08',
                'show_image' => '1',
                'is_requested' => 0,
                'brand_proof' => NULL,
            ),
        ));
        
        
    }
}