<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LocalesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('locales')->delete();
        
        \DB::table('locales')->insert(array (
            0 => 
            array (
                'id' => 1,
                'lang_code' => 'en',
                'name' => 'English',
                'def' => 1,
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'lang_code' => 'hi',
                'name' => 'Hindi',
                'def' => 0,
                'status' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'lang_code' => 'es',
                'name' => 'Spanish',
                'def' => 0,
                'status' => 1,
            ),
        ));
        
        
    }
}