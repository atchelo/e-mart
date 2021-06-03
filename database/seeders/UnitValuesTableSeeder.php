<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UnitValuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('unit_values')->delete();
        
        \DB::table('unit_values')->insert(array (
            0 => 
            array (
                'id' => 1,
                'unit_values' => 'Kilogram',
                'short_code' => 'kg',
                'unit_id' => 1,
                'created_at' => '2019-10-31 15:55:45',
                'updated_at' => '2019-10-31 15:55:45',
            ),
            1 => 
            array (
                'id' => 2,
                'unit_values' => 'Gram',
                'short_code' => 'g',
                'unit_id' => 1,
                'created_at' => '2019-10-31 15:55:56',
                'updated_at' => '2019-10-31 15:55:56',
            ),
            2 => 
            array (
                'id' => 3,
                'unit_values' => 'Miligram',
                'short_code' => 'mg',
                'unit_id' => 1,
                'created_at' => '2019-10-31 15:56:06',
                'updated_at' => '2019-10-31 15:56:06',
            ),
        ));
        
        
    }
}