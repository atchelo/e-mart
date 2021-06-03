<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MultiCurrenciesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('multi_currencies')->delete();
        
        \DB::table('multi_currencies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'position' => 'l',
                'row_id' => 1,
                'default_currency' => 1,
                'currency_id' => '53',
                'add_amount' => NULL,
                'currency_symbol' => 'fa fa-inr',
                'rate' => 1.0,
                'created_at' => NULL,
                'updated_at' => '2019-10-21 11:06:30',
            ),
        ));
        
        
    }
}