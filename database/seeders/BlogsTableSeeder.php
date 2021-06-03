<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BlogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('blogs')->delete();
        
        \DB::table('blogs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'heading' => '{"en":"Unique UI"}',
                'slug' => 'unique-ui',
                'image' => '1605787994blog_big_03.jpg',
                'des' => '{"en":"<p><strong>Sell like an over-hyped sales pitch<\\/strong><\\/p>"}',
                'user' => '{"en":"John"}',
                'about' => '{"en":null}',
                'post' => '{"en":"Admin"}',
                'status' => '1',
                'created_at' => '2020-11-19 17:34:08',
                'updated_at' => '2020-11-19 17:43:14',
            ),
            1 => 
            array (
                'id' => 2,
                'heading' => '{"en":"Build Upon Your Brand"}',
                'slug' => 'build-upon-your-brand',
                'image' => '1605787631blog_big_02.jpg',
                'des' => '{"en":"<p>Best Ecommerce Portal<\\/p>"}',
                'user' => '{"en":"admindesk"}',
                'about' => '{"en":null}',
                'post' => '{"en":"admindesk"}',
                'status' => '1',
                'created_at' => '2020-11-19 17:37:12',
                'updated_at' => '2020-11-19 17:37:19',
            ),
            2 => 
            array (
                'id' => 3,
                'heading' => '{"en":"Online Shopping"}',
                'slug' => 'online-shopping',
                'image' => '1605787952blog_big_01.jpg',
                'des' => '{"en":"<p>Some Demo Blog Description here....<\\/p>"}',
                'user' => '{"en":"Demo"}',
                'about' => '{"en":null}',
                'post' => '{"en":"Demo"}',
                'status' => '1',
                'created_at' => '2020-11-19 17:42:32',
                'updated_at' => '2020-11-19 17:42:32',
            ),
        ));
        
        
    }
}