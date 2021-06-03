<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TestimonialsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('testimonials')->delete();
        
        \DB::table('testimonials')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => '{"en":"Alice"}',
                'des' => '{"en":"<p>It can be a powerful, conversion-boosting, profit-driving tool for\\u00a0<strong>ecommerce<\\/strong>\\u00a0companies.<\\/p>"}',
                'post' => '{"en":"Chief Technology Officer"}',
                'rating' => '4',
                'image' => '1579779188member2.png',
                'status' => '1',
                'created_at' => '2020-01-23 16:00:42',
                'updated_at' => '2020-07-07 18:21:15',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => '{"en":"John Doe"}',
                'des' => '{"en":"<p>It can be a powerful, conversion-boosting, profit-driving tool for\\u00a0<strong>ecommerce<\\/strong>\\u00a0companies<\\/p>"}',
                'post' => '{"en":"Head Of Tech"}',
                'rating' => '5',
                'image' => '1579779252member3.png',
                'status' => '1',
                'created_at' => '2020-01-23 17:04:12',
                'updated_at' => '2020-07-07 18:21:23',
            ),
        ));
        
        
    }
}