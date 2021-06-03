<?php
namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PWASettingsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('p_w_a_settings')->delete();
        
        \DB::table('p_w_a_settings')->insert(array (
            0 => 
            array (
                'id' => 1,
                'icon_48' => 'icon_48x48.png',
                'icon_72' => 'icon_72x72.png',
                'icon_96' => 'icon_96x96.png',
                'icon_128' => 'icon_128x128.png',
                'icon_144' => 'icon_144x144.png',
                'icon_192' => 'icon_192x192.png',
                'icon_256' => 'icon_256x256.png',
                'icon_512' => 'icon_512x512.png',
                'splash_640' => 'splash-640x1136.png',
                'splash_750' => 'splash-750x1334.png',
                'splash_828' => 'splash-828x1792.png',
                'splash_1125' => 'splash-1125x2436.png',
                'splash_1242' => 'splash-1242x2208.png',
                'splash_1536' => 'splash-1536x2048.png',
                'splash_1668' => 'splash-1668x2224.png',
                'splash_2338' => 'splash-1668x2388.png',
                'splash_2048' => 'splash-2048x2732.png',
                'shorticon_1' => 'cart_5fe1ccf7d7478.png',
                'shorticon_2' => 'wishlist_5fe1ccf7d86c9.png',
                'shorticon_3' => 'login_5fe1ccf7d95f4.png',
                'created_at' => Carbon::now(),
                'updated_at' => '2020-12-22 12:43:00',
            ),
        ));
        
        
    }
}