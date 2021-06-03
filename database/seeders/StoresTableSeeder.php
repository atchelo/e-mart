<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StoresTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('stores')->delete();
        
        \DB::table('stores')->insert(array (
            0 => 
            array (
                'id' => 1,
                'user_id' => 1,
                'name' => 'eMart Zone',
                'address' => 'bhilwara',
                'phone' => '1234567890',
                'mobile' => '7894561230',
                'email' => 'emart@info.com',
                'city_id' => 3327,
                'country_id' => 101,
                'state_id' => 33,
                'pin_code' => '311001',
                'status' => '1',
                'verified_store' => '1',
                'website' => NULL,
                'store_logo' => '15618001471551923066logo.png',
                'branch' => NULL,
                'ifsc' => NULL,
                'account' => NULL,
                'bank_name' => NULL,
                'account_name' => NULL,
                'paypal_email' => NULL,
                'paytem_mobile' => NULL,
                'preferd' => NULL,
                'created_at' => '2019-02-17 16:16:56',
                'updated_at' => '2019-09-27 17:57:29',
                'apply_vender' => '1',
                'rd' => '0',
                'featured' => '0',
            ),
        ));
        
        
    }
}