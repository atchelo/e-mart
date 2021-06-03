<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SocialsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('socials')->delete();
        
        \DB::table('socials')->insert(array (
            0 => 
            array (
                'id' => 1,
                'url' => 'https://facebook.com',
                'icon' => 'fb',
                'status' => '1',
                'created_at' => '2020-02-04 11:20:27',
                'updated_at' => '2020-02-04 11:20:27',
            ),
            1 => 
            array (
                'id' => 2,
                'url' => 'https://twitter.com',
                'icon' => 'tw',
                'status' => '1',
                'created_at' => '2020-02-04 11:20:42',
                'updated_at' => '2020-02-04 11:20:42',
            ),
            2 => 
            array (
                'id' => 3,
                'url' => 'https://youtube.com',
                'icon' => 'youtube',
                'status' => '1',
                'created_at' => '2020-02-04 11:20:52',
                'updated_at' => '2020-02-04 11:20:52',
            ),
        ));
        
        
    }
}