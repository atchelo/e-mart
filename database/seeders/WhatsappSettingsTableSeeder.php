<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WhatsappSettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('whatsapp_settings')->delete();
        
        \DB::table('whatsapp_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'phone_no' => '1234567890',
                'position' => 'right',
                'size' => '60px',
                'headerTitle' => 'Chat with us',
                'popupMessage' => 'Hey there ! how can we help you?',
                'headerColor' => '#128C7E',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
        ));
        
        
    }
}