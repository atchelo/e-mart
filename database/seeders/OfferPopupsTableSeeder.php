<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OfferPopupsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('offer_popups')->delete();
        
        \DB::table('offer_popups')->insert(array (
            0 => 
            array (
                'id' => 1,
                'enable_popup' => 1,
                'image' => 'default.jpg',
                'heading' => '{"en":"Your heading text !"}',
                'heading_color' => '#4c67f0',
                'subheading' => '{"en":"Your subheading text !"}',
                'subheading_color' => '#000000',
                'description' => '{"en":"Some description here !!!"}',
                'description_text_color' => '#000000',
                'enable_button' => 1,
                'button_text' => '{"en":"Button Text !"}',
                'button_link' => '#',
                'button_text_color' => '#ffffff',
                'button_color' => '#0f37ff',
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ),
        ));
        
        
    }
}