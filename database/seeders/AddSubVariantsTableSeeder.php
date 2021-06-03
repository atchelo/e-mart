<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AddSubVariantsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('add_sub_variants')->delete();
        
        \DB::table('add_sub_variants')->insert(array (
            0 => 
            array (
                'id' => 1,
                'main_attr_id' => '["1","4"]',
                'main_attr_value' => '{"1":"1","4":"11"}',
                'price' => 0.0,
                'stock' => 48,
                'pro_id' => 11,
                'weight' => 200.0,
                'w_unit' => 2,
                'min_order_qty' => 1,
                'max_order_qty' => 1,
                'def' => 1,
                'created_at' => '2020-11-24 11:38:56',
                'updated_at' => '2020-11-24 15:58:15',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'main_attr_id' => '["3","4"]',
                'main_attr_value' => '{"3":"8","4":"11"}',
                'price' => 0.0,
                'stock' => 3,
                'pro_id' => 10,
                'weight' => 1.0,
                'w_unit' => 1,
                'min_order_qty' => 1,
                'max_order_qty' => 1,
                'def' => 1,
                'created_at' => '2020-11-24 12:48:45',
                'updated_at' => '2020-11-24 15:53:48',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'main_attr_id' => '["1"]',
                'main_attr_value' => '{"1":"6"}',
                'price' => 0.0,
                'stock' => 100,
                'pro_id' => 9,
                'weight' => 0.0,
                'w_unit' => 2,
                'min_order_qty' => 1,
                'max_order_qty' => 10,
                'def' => 1,
                'created_at' => '2020-11-24 12:53:31',
                'updated_at' => '2020-11-24 12:53:31',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'main_attr_id' => '["1"]',
                'main_attr_value' => '{"1":"6"}',
                'price' => 0.0,
                'stock' => 7,
                'pro_id' => 8,
                'weight' => 0.0,
                'w_unit' => 2,
                'min_order_qty' => 1,
                'max_order_qty' => 1,
                'def' => 1,
                'created_at' => '2020-11-24 14:28:32',
                'updated_at' => '2020-11-24 14:28:32',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'main_attr_id' => '["1"]',
                'main_attr_value' => '{"1":"25"}',
                'price' => 0.0,
                'stock' => 100,
                'pro_id' => 7,
                'weight' => 100.0,
                'w_unit' => 2,
                'min_order_qty' => 1,
                'max_order_qty' => 1,
                'def' => 1,
                'created_at' => '2020-11-24 14:35:24',
                'updated_at' => '2020-11-24 14:35:24',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'main_attr_id' => '["3"]',
                'main_attr_value' => '{"3":"7"}',
                'price' => 0.0,
                'stock' => 100,
                'pro_id' => 2,
                'weight' => 100.0,
                'w_unit' => 2,
                'min_order_qty' => 1,
                'max_order_qty' => 1,
                'def' => 1,
                'created_at' => '2020-11-24 14:37:52',
                'updated_at' => '2020-11-24 14:37:52',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}