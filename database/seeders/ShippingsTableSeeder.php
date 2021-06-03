<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShippingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shippings')->delete();
        
        \DB::table('shippings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Free Shipping',
                'price' => NULL,
                'free' => NULL,
                'login' => '1',
                'default_status' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Local Pickup',
                'price' => 50.0,
                'free' => NULL,
                'login' => '1',
                'default_status' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Flat Rate',
                'price' => 12.0,
                'free' => NULL,
                'login' => '1',
                'default_status' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'UPS Shipping',
                'price' => 5000.0,
                'free' => NULL,
                'login' => '1',
                'default_status' => '0',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'Shipping Price',
                'price' => NULL,
                'free' => NULL,
                'login' => '1',
                'default_status' => '1',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}