<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AffilatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('affilates')->delete();
        
        \DB::table('affilates')->insert(array (
            0 => 
            array (
                'id' => 1,
                'code_limit' => 6,
            'about_system' => '<p><strong><span style="font-size: 18pt; color: #e03e2d;">How it works ? <span style="font-size: 14pt;">&nbsp;</span></span><br /><br />Once the system is enabled user will able to put refer code on register screen if refer code is valid then settled amount is given to that referral user\'s wallet (IF his wallet is active).</strong><br /><strong>IF refer code is invalid user will see invalid refer code warning on register screen unless he put correct refer code or remove the refer code.</strong></p>
<p>IF <label><span style="color: #000000;"><strong>Credit wallet amount on first purchase settings</strong></span> is <span style="text-decoration: underline;"><strong>enabled </strong></span>then after being refered, user need to purchase something. Once their order is delivered successfully then referal code user will get their amount in <strong>wallet</strong>.&nbsp;</label><label class="switch"></label></p>
<p>IF <label><span style="color: #000000;"><strong>Credit wallet amount on first purchase settings</strong></span> is<strong> </strong><span style="text-decoration: underline;"><strong>dis</strong><strong>abled </strong></span>then after being refered, referal code user will get their amount in <strong>wallet</strong>.&nbsp;</label></p>
<p><span style="color: #000000;"><strong>After Enable the Affiliate system user will have a have a refer screen to share his affilated link and he will able to trace which user is signup with his refer code on his dashboard under My Account section.</strong></span></p>',
                'enable_affilate' => 0,
                'refer_amount' => 0.06,
                'enable_purchase' => 0,
                'created_at' => '2021-05-10 10:34:46',
                'updated_at' => '2021-05-10 22:26:43',
            ),
        ));
        
        
    }
}