<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GenralsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('genrals')->delete();
        
        \DB::table('genrals')->insert(array (
            0 => 
            array (
                'id' => 1,
                'project_name' => 'eMart',
                'email' => 'admindesk@emart.com',
                'title' => 'ecommerce',
                'currency_code' => NULL,
                'currency_symbol' => NULL,
                'pincode' => NULL,
                'copyright' => 'All Rights Reserved',
                'logo' => 'mainlogo.png',
                'fevicon' => 'mainfavicon.png',
                'address' => '127 - A, Street park, New York, USA',
                'mobile' => '7894561230',
                'login' => '0',
                'right_click' => '0',
                'inspect' => '0',
                'guest_login' => '1',
                'status' => '0',
                'vendor_enable' => 0,
                'created_at' => '2019-02-05 16:09:17',
                'updated_at' => '2019-10-10 21:00:04',
                'cart_amount' => 500.0,
            ),
        ));
        
        
    }
}