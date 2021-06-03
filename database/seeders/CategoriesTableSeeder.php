<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('categories')->delete();
        
        \DB::table('categories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '{"en":"Furniture"}',
                'icon' => 'fa-database',
                'image' => '1579087936Faye Floor Lamp, Brass and Marble 05-02.jpg',
                'description' => '{"en":"<p>Furniture refers to movable objects intended to support various human activities such as seating , eating , and sleeping. Furniture is also used to hold objects at a convenient height for work, or to store things. Furniture can be a product of design and is considered a form of decorative art.<\\/p>"}',
                'position' => 4,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-01-15 17:02:16',
                'updated_at' => '2020-06-20 18:20:16',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '{"en":"Electronics"}',
                'icon' => 'fa-camera-retro',
            'image' => '1579088104Fujifilm Instax Mini 9 Instant Camera (Ice Blue) 01-05.jpg',
                'description' => '{"en":"<p>A gadget as a small device or tool that is frequently novel or ingenious. Smartphones and tablets are the most obvious examples of electronic gadgets. ... Other examples of electronic gadgets include e-book readers, smartwatches, digital fitness trackers, GPS devices and video game machines.<\\/p>"}',
                'position' => 1,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-01-15 17:05:04',
                'updated_at' => '2020-06-20 18:20:17',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => '{"en":"Fashion"}',
                'icon' => 'fa-user-secret',
                'image' => '1579088345Denim overall skirt 04-01.jpg',
                'description' => '{"en":"<p>Fashion is a popular aesthetic expression in a certain time and context, especially in clothing, footwear, lifestyle, accessories, makeup, hairstyle and body proportions. ... Fashion instead describes the social and temporal system that &quot;activates&quot; dress as a social signifier in a certain time and context.<\\/p>"}',
                'position' => 2,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-01-15 17:09:05',
                'updated_at' => '2020-06-20 18:20:17',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => '{"en":"Watches"}',
                'icon' => 'fa-clock-o',
                'image' => '1579088418GEN 5 SMARTWATCH - THE CARLYLE HR BLACK SILICONE 03-03.jpg',
                'description' => '{"en":"<p>A watch is a timepiece intended to be carried or worn by a person. It is designed to keep working despite the motions caused by the person&#39;s activities. A wristwatch is designed to be worn around the wrist, attached by a watch strap or other type of bracelet. A pocket watch is designed for a person to carry in a pocket. The study of timekeeping is known as horology.&nbsp;<\\/p>"}',
                'position' => 3,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-01-15 17:10:18',
                'updated_at' => '2020-06-20 18:20:17',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => '{"en":"Sports Book and More"}',
                'icon' => 'fa-book',
                'image' => '1593522262top-view-back-school-supplies-with-globe-book_23-2148587140.jpg',
                'description' => '{"en":"<p>Find sport and books here...<\\/p>"}',
                'position' => 5,
                'status' => '1',
                'featured' => '0',
                'created_at' => '2020-02-24 12:04:20',
                'updated_at' => '2020-06-30 18:34:22',
            ),
        ));
        
        
    }
}