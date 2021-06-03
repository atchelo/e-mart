<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 'a',
                'name' => 'Admin',
                'email' => 'admindesk@mediacity.co.in',
                'email_verified_at' => NULL,
                'password' => bcrypt(123456),
                'mobile' => '1234567890',
                'phone' => '1234567890',
                'city_id' => 3327,
                'country_id' => 101,
                'state_id' => 33,
                'image' => NULL,
                'website' => NULL,
                'status' => 1,
                'apply_vender' => '0',
                'gender' => 'M',
                'remember_token' => NULL,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ),
        ));
        
        
    }
}