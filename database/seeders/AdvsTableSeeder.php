<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdvsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('advs')->delete();
        
        \DB::table('advs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'layout' => 'Single image layout',
                'position' => 'abovefeaturedproduct',
                'status' => 1,
                'image1' => '1606209610cat-banner-1.jpg',
                'image2' => NULL,
                'image3' => NULL,
                'url1' => NULL,
                'url2' => NULL,
                'url3' => NULL,
                'pro_id1' => NULL,
                'pro_id2' => NULL,
                'pro_id3' => NULL,
                'cat_id1' => 2,
                'cat_id2' => NULL,
                'cat_id3' => NULL,
                'created_at' => '2020-11-24 14:50:10',
                'updated_at' => '2020-11-24 14:50:10',
            ),
            1 => 
            array (
                'id' => 2,
                'layout' => 'Three Image Layout',
                'position' => 'abovenewproduct',
                'status' => 1,
                'image1' => '1606209691home-banner1.jpg',
                'image2' => '1606209691home-banner2.jpg',
                'image3' => '1606209691home-banner3.jpg',
                'url1' => NULL,
                'url2' => NULL,
                'url3' => NULL,
                'pro_id1' => NULL,
                'pro_id2' => NULL,
                'pro_id3' => NULL,
                'cat_id1' => 3,
                'cat_id2' => 4,
                'cat_id3' => 3,
                'created_at' => '2020-11-24 14:51:31',
                'updated_at' => '2020-11-24 14:51:31',
            ),
        ));
        
        
    }
}