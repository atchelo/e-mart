<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DashboardSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('dashboard_settings')->delete();
        
        \DB::table('dashboard_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'lat_ord' => 1,
                'rct_str' => 1,
                'rct_pro' => 1,
                'rct_cust' => 1,
                'max_item_ord' => '5',
                'max_item_str' => '5',
                'max_item_pro' => '5',
                'max_item_cust' => '3',
                'fb_wid' => 1,
                'tw_wid' => 1,
                'fb_page_id' => NULL,
                'fb_page_token' => NULL,
                'tw_username' => NULL,
                'inst_username' => NULL,
                'insta_wid' => 1,
                'created_at' => NULL,
                'updated_at' => '2019-10-23 15:33:46',
            ),
        ));
        
        
    }
}