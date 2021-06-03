<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AbusedsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('abuseds')->delete();
        
        \DB::table('abuseds')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'foo',
                'rep' => '***',
                'status' => '1',
                'created_at' => NULL,
                'updated_at' => '2019-12-15 20:42:29',
            ),
        ));
        
        
    }
}