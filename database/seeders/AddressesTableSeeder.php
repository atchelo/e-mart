<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AddressesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('addresses')->delete();
        
        \DB::table('addresses')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'John Doe',
                'address' => 'Theodore Lowe
Ap #867-859 Sit Rd.
Alden, New York 39531
(793) 151-6230',
                'phone' => 1234567890,
                'email' => 'john@example.com',
                'pin_code' => NULL,
                'city_id' => 47856,
                'state_id' => 3956,
                'country_id' => 231,
                'defaddress' => 1,
                'user_id' => 2,
                'created_at' => '2020-11-19 16:46:20',
                'updated_at' => '2020-11-19 16:46:20',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Celeste Slater',
                'address' => 'P.O. Box 887 2508 Dolor. Av.
Muskegon KY 12482',
                'phone' => 7931516230,
                'email' => 'john@example.com',
                'pin_code' => NULL,
                'city_id' => 44545,
                'state_id' => 3937,
                'country_id' => 231,
                'defaddress' => 0,
                'user_id' => 2,
                'created_at' => '2020-11-19 16:47:49',
                'updated_at' => '2020-11-19 16:47:49',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'admindesk',
                'address' => 'Studio 103
The Business Centre
61 Wellfield Road
Roath
Cardiff
CF24 3DG',
                'phone' => 123456980,
                'email' => 'admindesk@demo.com',
                'pin_code' => NULL,
                'city_id' => 42864,
                'state_id' => 3924,
                'country_id' => 231,
                'defaddress' => 1,
                'user_id' => 1,
                'created_at' => '2020-11-19 17:18:05',
                'updated_at' => '2020-11-19 17:18:10',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}