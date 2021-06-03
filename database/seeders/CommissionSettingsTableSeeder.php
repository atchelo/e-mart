<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CommissionSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('commission_settings')->delete();
        
        \DB::table('commission_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'rate' => '0',
                'type' => 'flat',
                'p_type' => 'p',
                'created_at' => '2019-03-01 15:51:51',
                'updated_at' => '2019-09-24 17:54:36',
            ),
        ));
        
        
    }
}