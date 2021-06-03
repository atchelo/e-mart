<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AddProductVariantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('add_product_variants')->delete();
        
        \DB::table('add_product_variants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'attr_name' => '1',
                'attr_value' => '["1","4","6"]',
                'pro_id' => 11,
                'created_at' => '2020-11-24 11:36:40',
                'updated_at' => '2020-11-24 11:36:40',
            ),
            1 => 
            array (
                'id' => 2,
                'attr_name' => '4',
                'attr_value' => '["11"]',
                'pro_id' => 11,
                'created_at' => '2020-11-24 11:36:51',
                'updated_at' => '2020-11-24 11:36:51',
            ),
            2 => 
            array (
                'id' => 3,
                'attr_name' => '3',
                'attr_value' => '["8"]',
                'pro_id' => 10,
                'created_at' => '2020-11-24 12:47:00',
                'updated_at' => '2020-11-24 12:47:00',
            ),
            3 => 
            array (
                'id' => 4,
                'attr_name' => '4',
                'attr_value' => '["11","12"]',
                'pro_id' => 10,
                'created_at' => '2020-11-24 12:47:16',
                'updated_at' => '2020-11-24 12:47:16',
            ),
            4 => 
            array (
                'id' => 5,
                'attr_name' => '1',
                'attr_value' => '["6"]',
                'pro_id' => 9,
                'created_at' => '2020-11-24 12:53:04',
                'updated_at' => '2020-11-24 12:53:04',
            ),
            5 => 
            array (
                'id' => 6,
                'attr_name' => '1',
                'attr_value' => '["6"]',
                'pro_id' => 8,
                'created_at' => '2020-11-24 14:28:03',
                'updated_at' => '2020-11-24 14:28:03',
            ),
            6 => 
            array (
                'id' => 7,
                'attr_name' => '1',
                'attr_value' => '["25"]',
                'pro_id' => 7,
                'created_at' => '2020-11-24 14:34:30',
                'updated_at' => '2020-11-24 14:34:30',
            ),
            7 => 
            array (
                'id' => 8,
                'attr_name' => '3',
                'attr_value' => '["7"]',
                'pro_id' => 2,
                'created_at' => '2020-11-24 14:36:31',
                'updated_at' => '2020-11-24 14:36:31',
            ),
        ));
        
        
    }
}