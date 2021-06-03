<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FooterMenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('footer_menus')->delete();
        
        \DB::table('footer_menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '{"en":"Privacy Policy"}',
                'link_by' => 'page',
                'position' => '2',
                'widget_postion' => 'footer_wid_3',
                'page_id' => 1,
                'url' => NULL,
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '{"en":"Terms of services"}',
                'link_by' => 'page',
                'position' => '2',
                'widget_postion' => 'footer_wid_3',
                'page_id' => 2,
                'url' => NULL,
                'status' => 1,
            ),
        ));
        
        
    }
}