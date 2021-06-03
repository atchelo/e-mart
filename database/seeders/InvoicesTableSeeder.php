<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class InvoicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('invoices')->delete();
        
        \DB::table('invoices')->insert(array (
            0 => 
            array (
                'id' => 1,
                'order_prefix' => 'EODD',
                'prefix' => 'EMRT',
                'postfix' => 'MRTE2019',
                'created_at' => NULL,
                'updated_at' => '2019-08-26 23:52:40',
                'seal' => '15659732311562050511emart-logo-thumb.png',
                'inv_start' => '101',
                'cod_prefix' => 'EMART',
                'cod_postfix' => 'COD',
                'terms' => 'Terms will shown here',
                'sign' => '156684376013100839_1074666292624494_7225825847260187043_n.jpg',
                'user_id' => 1,
            ),
        ));
        
        
    }
}