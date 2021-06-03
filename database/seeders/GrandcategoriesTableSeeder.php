<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class GrandcategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('grandcategories')->delete();
        
        \DB::table('grandcategories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '{"en":"Cucumber Pickles"}',
                'image' => '1594108826top-view-pickled-cucumber-sliced-wooden-cutting-board-bowl-brown-stone_176474-1018.jpg',
                'description' => '{"en":"<p><span style=\\"color:#4d5156;font-family:arial, sans-serif;background-color:#ffffff;\\">A pickled cucumber is a cucumber that has been pickled in a brine, vinegar, or other solution and left to ferment for a period of time, by either immersing the cucumbers in an acidic solution or through souring by lacto-fermentation. Pickled cucumbers are often part of mixed pickles.<\\/span><\\/p>"}',
                'parent_id' => 6,
                'subcat_id' => 26,
                'position' => 9,
                'status' => '1',
                'featured' => '1',
                'created_at' => '2020-07-07 13:30:26',
                'updated_at' => '2020-07-09 15:25:25',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '{"en":"Baby Boy"}',
                'image' => '1579089600Crew neck top with inlay 01-01.jpg',
                'description' => '{"en":"<p>Children&#39;s clothing or kids&#39; clothing is clothing for children who have not yet grown to full height. Grandma bait is a retail industry term for expensive children&#39;s clothing. Children&#39;s clothing is often more casual than adult clothing, fit for play and rest. Hosiery is commonly used.<\\/p>"}',
                'parent_id' => 3,
                'subcat_id' => 4,
                'position' => 5,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-01-15 17:30:00',
                'updated_at' => '2020-07-09 15:25:25',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => '{"en":"Baby Girl"}',
                'image' => '1579089631Allover print dress 02-01.jpg',
                'description' => '{"en":"<p>Children&#39;s clothing or kids&#39; clothing is clothing for children who have not yet grown to full height. Grandma bait is a retail industry term for expensive children&#39;s clothing. Children&#39;s clothing is often more casual than adult clothing, fit for play and rest. Hosiery is commonly used.<\\/p>"}',
                'parent_id' => 3,
                'subcat_id' => 4,
                'position' => 4,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-01-15 17:30:31',
                'updated_at' => '2020-07-09 15:25:25',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => '{"en":"Bags"}',
                'image' => '1579089703SC30 Undeniable Backpack 01-01.jpg',
                'description' => '{"en":"<p>Whether you go to the gym or you are a sports enthusiast, having a sports bag or gym bags is more than a necessity. Sports bags usually resemble duffel bags. Duffel bags are nothing but a large cylindrical bag made of fabric or leather featuring a zip closure on the top.<\\/p>"}',
                'parent_id' => 3,
                'subcat_id' => 5,
                'position' => 3,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-01-15 17:31:43',
                'updated_at' => '2020-07-09 15:25:25',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => '{"en":"Bottoms"}',
                'image' => '1579089761Boys Shorts 01-01.jpg',
                'description' => '{"en":"<p>Ethnic Bottoms - Buy Ethnic Bottom Wear Online for Women - Browse new arrival in Ethnic Bottoms, Check latest price in India and shop at India\'s favourite<\\/p>"}',
                'parent_id' => 3,
                'subcat_id' => 5,
                'position' => 1,
                'status' => '1',
                'featured' => '1',
                'created_at' => '2020-01-15 17:32:41',
                'updated_at' => '2020-08-04 16:46:03',
            ),
        ));
        
        
    }
}