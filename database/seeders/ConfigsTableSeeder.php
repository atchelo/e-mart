<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ConfigsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('configs')->delete();
        
        \DB::table('configs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'payu_enable' => 0,
                'instamojo_enable' => 0,
                'stripe_enable' => 0,
                'paypal_enable' => 0,
                'fb_login_enable' => 0,
                'google_login_enable' => 0,
                'pincode_system' => 0,
                'sms_channel' => 0,
                'created_at' => '2019-04-09 17:41:41',
                'updated_at' => '2019-08-27 15:11:05',
            ),
        ));
        
        
    }
}