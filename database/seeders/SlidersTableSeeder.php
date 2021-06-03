<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('sliders')->delete();
        
        \DB::table('sliders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'link_by' => 'none',
                'category_id' => NULL,
                'child' => NULL,
                'grand_id' => NULL,
                'topheading' => '{"en":"Fashion Deals"}',
                'heading' => '{"en":"60% off"}',
                'buttonname' => '{"en":"SHOP NOW"}',
                'btntextcolor' => '#ffffff',
                'btnbgcolor' => '#000000',
                'moredesc' => NULL,
                'moredesccolor' => '#000000',
                'image' => '160578619102.jpg',
                'url' => NULL,
                'headingtextcolor' => '#000000',
                'subheadingcolor' => '#000000',
                'product_id' => NULL,
                'status' => '1',
                'created_at' => '2020-11-19 17:13:11',
                'updated_at' => '2020-11-19 17:13:42',
            ),
            1 => 
            array (
                'id' => 2,
                'link_by' => 'none',
                'category_id' => NULL,
                'child' => NULL,
                'grand_id' => NULL,
                'topheading' => '{"en":"Music Never Stops"}',
                'heading' => '{"en":"Arrival of smart era"}',
                'buttonname' => '{"en":"BUY NOW"}',
                'btntextcolor' => '#ffffff',
                'btnbgcolor' => '#de3b3b',
                'moredesc' => NULL,
                'moredesccolor' => '#000000',
                'image' => '160578632001.jpg',
                'url' => NULL,
                'headingtextcolor' => '#ffffff',
                'subheadingcolor' => '#ffffff',
                'product_id' => NULL,
                'status' => '1',
                'created_at' => '2020-11-19 17:15:21',
                'updated_at' => '2020-11-19 17:15:37',
            ),
        ));
        
        
    }
}