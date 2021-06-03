<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('units')->delete();
        
        \DB::table('units')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'Mass',
                'status' => '1',
                'created_at' => '2019-10-31 15:55:29',
                'updated_at' => '2019-10-31 15:55:29',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Color',
                'status' => '1',
                'created_at' => '2019-10-31 15:56:49',
                'updated_at' => '2019-10-31 15:56:49',
            ),
        ));
        
        
    }
}