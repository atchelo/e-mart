<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductAttributesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_attributes')->delete();
        
        \DB::table('product_attributes')->insert(array (
            0 => 
            array (
                'id' => 1,
                'attr_name' => 'Color',
                'cats_id' => '["1","2","3","4","5"]',
                'unit_id' => 2,
                'created_at' => '2020-11-19 17:59:44',
                'updated_at' => '2020-11-19 17:59:44',
            ),
            1 => 
            array (
                'id' => 3,
                'attr_name' => 'Storage',
                'cats_id' => '["2","4"]',
                'unit_id' => 3,
                'created_at' => '2020-11-19 18:02:29',
                'updated_at' => '2020-11-19 18:02:29',
            ),
            2 => 
            array (
                'id' => 4,
                'attr_name' => 'RAM',
                'cats_id' => '["2","4"]',
                'unit_id' => 3,
                'created_at' => '2020-11-19 18:03:24',
                'updated_at' => '2020-11-19 18:03:24',
            ),
            3 => 
            array (
                'id' => 5,
                'attr_name' => 'Size',
                'cats_id' => '["3"]',
                'unit_id' => 4,
                'created_at' => '2020-11-19 18:04:54',
                'updated_at' => '2020-11-19 18:04:54',
            ),
        ));
        
        
    }
}