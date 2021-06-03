<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('menus')->delete();
        
        \DB::table('menus')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '{"en":"Home"}',
                'icon' => 'fa-home',
                'link_by' => 'url',
                'cat_id' => NULL,
                'page_id' => NULL,
                'url' => 'http://localhost/publicdemo/public/',
                'position' => 1,
                'show_cat_in_dropdown' => 0,
                'linked_parent' => NULL,
                'show_child_in_dropdown' => 0,
                'linked_child' => NULL,
                'bannerimage' => NULL,
                'img_link' => NULL,
                'menu_tag' => 0,
                'tag_bg' => NULL,
                'tag_color' => NULL,
                'tag_text' => '{"en":null}',
                'show_image' => 0,
                'status' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '{"en":"Offer Zone"}',
                'icon' => 'fa-star-half-empty',
                'link_by' => 'cat',
                'cat_id' => 0,
                'page_id' => NULL,
                'url' => NULL,
                'position' => 2,
                'show_cat_in_dropdown' => 1,
                'linked_parent' => '["1","2","3"]',
                'show_child_in_dropdown' => 0,
                'linked_child' => '["1","2","3","7","8","9","4","5","6"]',
                'bannerimage' => NULL,
                'img_link' => NULL,
                'menu_tag' => 1,
                'tag_bg' => '#3be340',
                'tag_color' => '#ffffff',
                'tag_text' => '{"en":"Limited Time"}',
                'show_image' => 0,
                'status' => 1,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => '{"en":"Deals In Electronics"}',
                'icon' => 'fa-bolt',
                'link_by' => 'cat',
                'cat_id' => 2,
                'page_id' => NULL,
                'url' => NULL,
                'position' => 3,
                'show_cat_in_dropdown' => 0,
                'linked_parent' => NULL,
                'show_child_in_dropdown' => 0,
                'linked_child' => NULL,
                'bannerimage' => NULL,
                'img_link' => NULL,
                'menu_tag' => 1,
                'tag_bg' => '#ff0505',
                'tag_color' => '#ffffff',
                'tag_text' => '{"en":"50 % off"}',
                'show_image' => 0,
                'status' => 1,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => '{"en":"Fashion Hub"}',
                'icon' => 'fa-chain-broken',
                'link_by' => 'cat',
                'cat_id' => 3,
                'page_id' => NULL,
                'url' => NULL,
                'position' => 4,
                'show_cat_in_dropdown' => 0,
                'linked_parent' => NULL,
                'show_child_in_dropdown' => 0,
                'linked_child' => NULL,
                'bannerimage' => NULL,
                'img_link' => NULL,
                'menu_tag' => 1,
                'tag_bg' => '#ed078e',
                'tag_color' => '#ffffff',
                'tag_text' => '{"en":"New Collection !"}',
                'show_image' => 0,
                'status' => 1,
            ),
        ));
        
        
    }
}