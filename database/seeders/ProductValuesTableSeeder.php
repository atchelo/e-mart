<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductValuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('product_values')->delete();
        
        \DB::table('product_values')->insert(array (
            0 => 
            array (
                'id' => 1,
                'values' => 'RED',
                'atrr_id' => '1',
                'unit_value' => '#ff0d0d',
                'created_at' => '2020-11-19 17:59:57',
                'updated_at' => '2020-11-19 17:59:57',
            ),
            1 => 
            array (
                'id' => 2,
                'values' => 'PURPLE',
                'atrr_id' => '1',
                'unit_value' => '#c100ff',
                'created_at' => '2020-11-19 18:00:09',
                'updated_at' => '2020-11-19 18:00:09',
            ),
            2 => 
            array (
                'id' => 3,
                'values' => 'BLUE',
                'atrr_id' => '1',
                'unit_value' => '#3c4bee',
                'created_at' => '2020-11-19 18:00:19',
                'updated_at' => '2020-11-19 18:00:19',
            ),
            3 => 
            array (
                'id' => 4,
                'values' => 'BLACK',
                'atrr_id' => '1',
                'unit_value' => '#15020c',
                'created_at' => '2020-11-19 18:00:25',
                'updated_at' => '2020-11-19 18:00:25',
            ),
            4 => 
            array (
                'id' => 5,
                'values' => 'WHITE',
                'atrr_id' => '1',
                'unit_value' => '#f1f1f1',
                'created_at' => '2020-11-19 18:00:33',
                'updated_at' => '2020-11-19 18:00:33',
            ),
            5 => 
            array (
                'id' => 6,
                'values' => 'SILVER',
                'atrr_id' => '1',
                'unit_value' => '#c5bac5',
                'created_at' => '2020-11-19 18:00:41',
                'updated_at' => '2020-11-19 18:00:41',
            ),
            6 => 
            array (
                'id' => 7,
                'values' => '32',
                'atrr_id' => '3',
                'unit_value' => 'GB',
                'created_at' => '2020-11-19 18:02:36',
                'updated_at' => '2020-11-19 18:02:45',
            ),
            7 => 
            array (
                'id' => 8,
                'values' => '1',
                'atrr_id' => '3',
                'unit_value' => 'TB',
                'created_at' => '2020-11-19 18:03:09',
                'updated_at' => '2020-11-19 18:03:09',
            ),
            8 => 
            array (
                'id' => 9,
                'values' => '128',
                'atrr_id' => '3',
                'unit_value' => 'GB',
                'created_at' => '2020-11-19 18:03:12',
                'updated_at' => '2020-11-19 18:03:12',
            ),
            9 => 
            array (
                'id' => 10,
                'values' => '256',
                'atrr_id' => '3',
                'unit_value' => 'GB',
                'created_at' => '2020-11-19 18:03:15',
                'updated_at' => '2020-11-19 18:03:15',
            ),
            10 => 
            array (
                'id' => 11,
                'values' => '4',
                'atrr_id' => '4',
                'unit_value' => 'GB',
                'created_at' => '2020-11-19 18:03:28',
                'updated_at' => '2020-11-19 18:03:28',
            ),
            11 => 
            array (
                'id' => 12,
                'values' => '8',
                'atrr_id' => '4',
                'unit_value' => 'GB',
                'created_at' => '2020-11-19 18:03:32',
                'updated_at' => '2020-11-19 18:03:32',
            ),
            12 => 
            array (
                'id' => 13,
                'values' => '32',
                'atrr_id' => '4',
                'unit_value' => 'GB',
                'created_at' => '2020-11-19 18:03:36',
                'updated_at' => '2020-11-19 18:03:36',
            ),
            13 => 
            array (
                'id' => 14,
                'values' => '16',
                'atrr_id' => '4',
                'unit_value' => 'GB',
                'created_at' => '2020-11-19 18:03:39',
                'updated_at' => '2020-11-19 18:03:39',
            ),
            14 => 
            array (
                'id' => 15,
                'values' => '256',
                'atrr_id' => '4',
                'unit_value' => 'MB',
                'created_at' => '2020-11-19 18:03:43',
                'updated_at' => '2020-11-19 18:03:43',
            ),
            15 => 
            array (
                'id' => 16,
                'values' => '128',
                'atrr_id' => '4',
                'unit_value' => 'MB',
                'created_at' => '2020-11-19 18:03:48',
                'updated_at' => '2020-11-19 18:03:48',
            ),
            16 => 
            array (
                'id' => 17,
                'values' => 'S',
                'atrr_id' => '5',
                'unit_value' => 'S',
                'created_at' => '2020-11-19 18:05:02',
                'updated_at' => '2020-11-19 18:05:02',
            ),
            17 => 
            array (
                'id' => 18,
                'values' => 'M',
                'atrr_id' => '5',
                'unit_value' => 'M',
                'created_at' => '2020-11-19 18:05:10',
                'updated_at' => '2020-11-19 18:05:19',
            ),
            18 => 
            array (
                'id' => 19,
                'values' => 'L',
                'atrr_id' => '5',
                'unit_value' => 'L',
                'created_at' => '2020-11-19 18:05:33',
                'updated_at' => '2020-11-19 18:05:33',
            ),
            19 => 
            array (
                'id' => 20,
                'values' => 'XL',
                'atrr_id' => '5',
                'unit_value' => 'XL',
                'created_at' => '2020-11-19 18:05:37',
                'updated_at' => '2020-11-19 18:05:37',
            ),
            20 => 
            array (
                'id' => 21,
                'values' => 'XS',
                'atrr_id' => '5',
                'unit_value' => 'XS',
                'created_at' => '2020-11-19 18:05:42',
                'updated_at' => '2020-11-19 18:05:42',
            ),
            21 => 
            array (
                'id' => 22,
                'values' => '15',
                'atrr_id' => '5',
                'unit_value' => 'inc',
                'created_at' => '2020-11-19 18:06:59',
                'updated_at' => '2020-11-19 18:06:59',
            ),
            22 => 
            array (
                'id' => 23,
                'values' => '32',
                'atrr_id' => '5',
                'unit_value' => 'mtr',
                'created_at' => '2020-11-19 18:07:04',
                'updated_at' => '2020-11-19 18:07:04',
            ),
            23 => 
            array (
                'id' => 24,
                'values' => '16',
                'atrr_id' => '5',
                'unit_value' => 'cm',
                'created_at' => '2020-11-19 18:07:09',
                'updated_at' => '2020-11-19 18:07:09',
            ),
            24 => 
            array (
                'id' => 25,
                'values' => 'Gold',
                'atrr_id' => '1',
                'unit_value' => '#ecc524',
                'created_at' => '2020-11-24 14:34:20',
                'updated_at' => '2020-11-24 14:34:20',
            ),
        ));
        
        
    }
}