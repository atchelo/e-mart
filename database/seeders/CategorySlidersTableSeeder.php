<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategorySlidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('category_sliders')->delete();
        
        \DB::table('category_sliders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'category_ids' => '["2"]',
                'pro_limit' => 10,
                'status' => 1,
            ),
        ));
        
        
    }
}