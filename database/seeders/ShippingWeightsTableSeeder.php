<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShippingWeightsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shipping_weights')->delete();
        
        \DB::table('shipping_weights')->insert(array (
            0 => 
            array (
                'id' => 1,
                'vender_id' => 1,
                'weight_from_0' => '0',
                'weight_to_0' => '10',
                'weight_price_0' => '10',
                'per_oq_0' => 'po',
                'weight_from_1' => '21',
                'weight_to_1' => '40',
                'weight_price_1' => '50',
                'per_oq_1' => 'po',
                'weight_from_2' => '41',
                'weight_to_2' => '60',
                'weight_price_2' => '30',
                'per_oq_2' => 'po',
                'weight_from_3' => '61',
                'weight_to_3' => '80',
                'weight_price_3' => '40',
                'per_oq_3' => 'pq',
                'weight_from_4' => '81',
                'weight_price_4' => '40',
                'per_oq_4' => 'pq',
                'created_at' => NULL,
                'updated_at' => '2019-09-28 13:17:20',
            ),
        ));
        
        
    }
}