<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SubcategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('subcategories')->delete();
        
        \DB::table('subcategories')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => '{"en":"Bed"}',
                'icon' => 'fa-bed',
                'image' => '1579088525Kida King Size Bed, Royal Blue Velvet and Brass Legs 02-04.jpg',
                'description' => '{"en":"<p>A\\u00a0<strong>bed<\\/strong>\\u00a0is a piece of furniture which is used as a place to sleep or relax. Most modern\\u00a0<strong>beds<\\/strong>\\u00a0consist of a soft, cushioned mattress on a\\u00a0<strong>bed<\\/strong>\\u00a0frame, the mattress resting either on a solid base, often wood slats, or a sprung base. ... Some\\u00a0<strong>beds<\\/strong>\\u00a0are made especially for animals.<\\/p>"}',
                'parent_cat' => 1,
                'position' => 3,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:12:05',
                'updated_at' => '2020-07-07 14:30:50',
            ),
            1 => 
            array (
                'id' => 2,
                'title' => '{"en":"Lamp"}',
                'icon' => 'fa-lightbulb-o',
                'image' => '1579088628.jpg',
                'description' => '{"en":"<p>A\\u00a0<strong>lamp<\\/strong>\\u00a0is a device that makes light and heat.\\u00a0<strong>Lamps<\\/strong>\\u00a0usually work with electricity, using a lightbulb. In the United States, a\\u00a0<strong>lamp<\\/strong>\\u00a0is usually considered a desk\\u00a0<strong>lamp<\\/strong>\\u00a0or floor\\u00a0<strong>lamp<\\/strong>. ... Before electric\\u00a0<strong>lamps<\\/strong>\\u00a0were invented, gas\\u00a0<strong>lamps<\\/strong>, oil\\u00a0<strong>lamps<\\/strong>\\u00a0or candles were used.<\\/p>"}',
                'parent_cat' => 1,
                'position' => 10,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:13:10',
                'updated_at' => '2020-07-07 14:30:44',
            ),
            2 => 
            array (
                'id' => 3,
                'title' => '{"en":"Sofa-Chair"}',
                'icon' => 'fa-wheelchair-alt',
                'image' => '1579088727Kooper Accent Armchair, Seafoam Blue Velvet 06-02.jpg',
                'description' => '{"en":"<p><strong>Sofa-Chairs<\\/strong>\\u00a0can be made from wood, metal, or other strong materials, like stone or acrylic. In some cases, multiple materials are used to construct a\\u00a0<strong>chair<\\/strong>; for example, the legs and frame may be made from metal and the seat and back may be made from plastic.<\\/p>"}',
                'parent_cat' => 1,
                'position' => 2,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:15:27',
                'updated_at' => '2020-07-07 14:30:57',
            ),
            3 => 
            array (
                'id' => 4,
                'title' => '{"en":"Kids"}',
                'icon' => 'fa-child',
                'image' => '1579088815Zip-up sweatshirt with bands 04-01.jpg',
                'description' => '{"en":"<p>Children\'s clothing or kids\' clothing is clothing for children who have not yet grown to full height. Grandma bait is a retail industry term for expensive children\'s clothing. Children\'s clothing is often more casual than adult clothing, fit for play and rest. Hosiery is commonly used.<\\/p>"}',
                'parent_cat' => 3,
                'position' => 1,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:16:55',
                'updated_at' => '2020-07-07 14:31:08',
            ),
            4 => 
            array (
                'id' => 5,
                'title' => '{"en":"Men"}',
                'icon' => 'fa-male',
                'image' => '1579088988Men\'s Hoddie 05-01.jpg',
                'description' => '{"en":"<p>Mens Clothing - Shop from the latest collection of Apparels for Men Online in India. Choose from wide range of mens fashion apparels by top brands on emart<\\/p>"}',
                'parent_cat' => 3,
                'position' => 5,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:19:48',
                'updated_at' => '2020-06-20 15:34:17',
            ),
            5 => 
            array (
                'id' => 6,
                'title' => '{"en":"Women"}',
                'icon' => 'fa-female',
                'image' => '1579089041UA Fly-By Women\'s Running Shorts 02-03 .jpg',
                'description' => '{"en":"<p>In Western societies, skirts, dresses and high-heeled shoes are usually seen as women\'s clothing, while neckties are usually seen as men\'s clothing. Trousers were once seen as exclusively male clothing, but can nowadays be worn by both genders.<\\/p>"}',
                'parent_cat' => 3,
                'position' => 6,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:20:41',
                'updated_at' => '2020-07-07 14:31:16',
            ),
            6 => 
            array (
                'id' => 7,
                'title' => '{"en":"Camera"}',
                'icon' => 'fa-camera',
                'image' => '1579089151Canon IXUS 185 03-02.jpg',
                'description' => '{"en":"<p>A camera is an optical instrument used to record images. At their most basic, cameras are sealed boxes with small holes that let light in to capture an image on a light-sensitive surface. Cameras have various mechanisms to control how the light falls onto the light-sensitive surface.\\u00a0<\\/p>"}',
                'parent_cat' => 2,
                'position' => 7,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:22:31',
                'updated_at' => '2020-07-07 14:31:28',
            ),
            7 => 
            array (
                'id' => 8,
                'title' => '{"en":"iPad"}',
                'icon' => 'fa-mobile-phone',
                'image' => '1579089304Apple iPad Pro Grey 01-05.jpg',
                'description' => '{"en":"<p>The iPad is a touchscreen tablet PC made by Apple . The original iPad debuted in 2010. ... They run Apple\'s iOS mobile operating system and have Wi-Fi connectivity with optional 4G capabilities.<\\/p>"}',
                'parent_cat' => 2,
                'position' => 8,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:25:04',
                'updated_at' => '2020-07-07 14:37:13',
            ),
            8 => 
            array (
                'id' => 9,
                'title' => '{"en":"Laptop"}',
                'icon' => 'fa-laptop',
                'image' => '1579089444.jpg',
                'description' => '{"en":"<p>A laptop , often called a notebook, is a small, portable personal computer with a \\"clamshell\\" form factor, typically having a thin LCD or LED computer screen mounted on the inside of the upper lid of the clamshell and an alphanumeric keyboard on the inside of the lower lid.<\\/p>"}',
                'parent_cat' => 2,
                'position' => 9,
                'status' => 1,
                'featured' => 0,
                'created_at' => '2020-01-15 17:26:59',
                'updated_at' => '2020-07-07 14:37:31',
            ),
            9 => 
            array (
                'id' => 10,
                'title' => '{"en":"Mens Watches"}',
                'icon' => 'fa-archive',
                'image' => NULL,
                'description' => '{"en":"<p>All men\'s watches find here<\\/p>"}',
                'parent_cat' => 4,
                'position' => 10,
                'status' => 1,
                'featured' => 1,
                'created_at' => '2020-11-24 14:32:23',
                'updated_at' => '2020-11-24 14:32:23',
            ),
        ));
        
        
    }
}