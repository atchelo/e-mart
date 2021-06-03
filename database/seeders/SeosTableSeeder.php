<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SeosTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('seos')->delete();
        
        \DB::table('seos')->insert(array (
            0 => 
            array (
                'id' => 1,
                'project_name' => 'eMart',
                'metadata_des' => 'explore us',
                'metadata_key' => 'online shopping portal',
                'google_analysis' => '{key}',
                'fb_pixel' => '{key}',
                'created_at' => '2019-02-14 13:20:48',
                'updated_at' => '2019-07-01 10:39:23',
            ),
        ));
        
        
    }
}