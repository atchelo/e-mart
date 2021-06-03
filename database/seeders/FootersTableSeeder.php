<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FootersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('footers')->delete();
        
        \DB::table('footers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'shiping' => '{"en":"Shipping over all world"}',
                'mobile' => '{"en":"24X7 Support"}',
                'return' => '{"en":"30 Days Return"}',
                'money' => '{"en":"Money Back Guarantee"}',
                'icon_section1' => 'fa-truck',
                'icon_section2' => 'fa-volume-control-phone',
                'icon_section3' => 'fa-money',
                'icon_section4' => 'fa-american-sign-language-interpreting',
                'footer2' => '{"en":"Customer Services"}',
                'footer3' => '{"en":"Our Policies"}',
                'footer4' => '{"en":"Quick Tour"}',
                'created_at' => '2019-02-06 19:30:23',
                'updated_at' => '2020-02-03 21:41:02',
            ),
        ));
        
        
    }
}