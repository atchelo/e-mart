<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('orders')->delete();
        
        \DB::table('orders')->insert(array (
            0 => 
            array (
                'id' => 1,
                'order_id' => '5fbcd3c718e78',
                'qty_total' => 2,
                'user_id' => 2,
                'vender_ids' => '[1]',
                'pro_id' => '[1,2]',
                'main_pro_id' => '[11,10]',
                'delivery_address' => 1,
            'billing_address' => '{"firstname":"John Doe","address":"Theodore Lowe\\r\\nAp #867-859 Sit Rd.\\r\\nAlden, New York 39531\\r\\n(793) 151-6230","email":"john@example.com","country_id":231,"city":47856,"state":3956,"total":null,"mobile":1234567890,"pincode":null}',
                'payment_method' => 'COD',
                'payment_receive' => 'no',
                'transaction_id' => 'EMARTudOn0E81eqCOD',
                'sale_id' => NULL,
                'order_status' => NULL,
                'status' => 1,
                'discount' => 0.0,
                'distype' => NULL,
                'coupon' => NULL,
                'order_total' => 590.0,
                'handlingcharge' => 0.0,
                'shipping' => '0',
                'paid_in' => 'fa fa-inr',
                'tax_amount' => '8.57',
                'created_at' => '2020-11-24 15:05:03',
                'updated_at' => NULL,
                'paid_in_currency' => 'INR',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'order_id' => '5fbcd80407985',
                'qty_total' => 3,
                'user_id' => 2,
                'vender_ids' => '[1]',
                'pro_id' => '[2,4,1]',
                'main_pro_id' => '[10,8,11]',
                'delivery_address' => 2,
                'billing_address' => '{"firstname":"Celeste Slater","address":"P.O. Box 887 2508 Dolor. Av.\\r\\nMuskegon KY 12482","email":"john@example.com","country_id":231,"city":44545,"state":3937,"total":null,"mobile":7931516230,"pincode":null}',
                'payment_method' => 'BankTransfer',
                'payment_receive' => 'no',
                'transaction_id' => 'EMARTcr5a9mfLbBCOD',
                'sale_id' => NULL,
                'order_status' => NULL,
                'status' => 1,
                'discount' => 0.0,
                'distype' => NULL,
                'coupon' => NULL,
                'order_total' => 1430.0,
                'handlingcharge' => 0.0,
                'shipping' => '0',
                'paid_in' => 'fa fa-inr',
                'tax_amount' => '167.08',
                'created_at' => '2020-11-24 15:23:08',
                'updated_at' => NULL,
                'paid_in_currency' => 'INR',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'order_id' => '5fbcd83029028',
                'qty_total' => 3,
                'user_id' => 2,
                'vender_ids' => '[1]',
                'pro_id' => '[2,4,1]',
                'main_pro_id' => '[10,8,11]',
                'delivery_address' => 2,
                'billing_address' => '{"firstname":"Celeste Slater","address":"P.O. Box 887 2508 Dolor. Av.\\r\\nMuskegon KY 12482","email":"john@example.com","country_id":231,"city":44545,"state":3937,"total":null,"mobile":7931516230,"pincode":null}',
                'payment_method' => 'BankTransfer',
                'payment_receive' => 'no',
                'transaction_id' => 'EMARTAZVVBJh4dzCOD',
                'sale_id' => NULL,
                'order_status' => NULL,
                'status' => 1,
                'discount' => 0.0,
                'distype' => NULL,
                'coupon' => NULL,
                'order_total' => 1430.0,
                'handlingcharge' => 0.0,
                'shipping' => '0',
                'paid_in' => 'fa fa-inr',
                'tax_amount' => '167.08',
                'created_at' => '2020-11-24 15:23:52',
                'updated_at' => NULL,
                'paid_in_currency' => 'INR',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'order_id' => '5fbcd847475fb',
                'qty_total' => 3,
                'user_id' => 2,
                'vender_ids' => '[1]',
                'pro_id' => '[2,4,1]',
                'main_pro_id' => '[10,8,11]',
                'delivery_address' => 2,
                'billing_address' => '{"firstname":"Celeste Slater","address":"P.O. Box 887 2508 Dolor. Av.\\r\\nMuskegon KY 12482","email":"john@example.com","country_id":231,"city":44545,"state":3937,"total":null,"mobile":7931516230,"pincode":null}',
                'payment_method' => 'BankTransfer',
                'payment_receive' => 'no',
                'transaction_id' => 'EMARTGlvdh9CpPtCOD',
                'sale_id' => NULL,
                'order_status' => NULL,
                'status' => 1,
                'discount' => 0.0,
                'distype' => NULL,
                'coupon' => NULL,
                'order_total' => 1430.0,
                'handlingcharge' => 0.0,
                'shipping' => '0',
                'paid_in' => 'fa fa-inr',
                'tax_amount' => '167.08',
                'created_at' => '2020-11-24 15:24:15',
                'updated_at' => NULL,
                'paid_in_currency' => 'INR',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}