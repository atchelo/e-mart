<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VariantImagesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('variant_images')->delete();
        
        \DB::table('variant_images')->insert(array (
            0 => 
            array (
                'id' => 1,
                'image1' => 'variant_1606198136AqiR8KNgf8.jpg',
                'image2' => 'variant_1606198136fw0UaXDTTI.jpg',
                'image3' => 'variant_1606198136GgcEsKkjkz.jpg',
                'image4' => 'variant_1606198136gh0eUlVpLW.jpg',
                'image5' => NULL,
                'image6' => NULL,
                'main_image' => 'variant_1606198136AqiR8KNgf8.jpg',
                'var_id' => 1,
                'created_at' => '2020-11-24 11:38:56',
                'updated_at' => '2020-11-24 11:38:56',
            ),
            1 => 
            array (
                'id' => 2,
                'image1' => 'variant_1606202325AldGCE0ykB.png',
                'image2' => 'variant_1606202325RNKExsWBIr.png',
                'image3' => 'variant_16062023256bKRh9SAHN.jpg',
                'image4' => NULL,
                'image5' => NULL,
                'image6' => NULL,
                'main_image' => 'variant_1606202325AldGCE0ykB.png',
                'var_id' => 2,
                'created_at' => '2020-11-24 12:48:45',
                'updated_at' => '2020-11-24 12:48:45',
            ),
            2 => 
            array (
                'id' => 3,
                'image1' => 'variant_1606202663RpYmryqttm.png',
                'image2' => 'variant_16062026635Rul6Unojc.png',
                'image3' => NULL,
                'image4' => NULL,
                'image5' => NULL,
                'image6' => NULL,
                'main_image' => 'variant_1606202663RpYmryqttm.png',
                'var_id' => 3,
                'created_at' => '2020-11-24 12:54:18',
                'updated_at' => '2020-11-24 12:54:24',
            ),
            3 => 
            array (
                'id' => 4,
                'image1' => 'variant_1606208312d7Wc8fsqlM.png',
                'image2' => 'variant_1606208312u4bBpccs3q.png',
                'image3' => 'variant_1606208312Sif9H01JLg.jpg',
                'image4' => NULL,
                'image5' => NULL,
                'image6' => NULL,
                'main_image' => 'variant_1606208312d7Wc8fsqlM.png',
                'var_id' => 4,
                'created_at' => '2020-11-24 14:28:32',
                'updated_at' => '2020-11-24 14:28:32',
            ),
            4 => 
            array (
                'id' => 5,
                'image1' => 'variant_1606208724wgDCM5uiIg.png',
                'image2' => 'variant_1606208724EnXtJBtjr7.png',
                'image3' => 'variant_1606208725d9hcu8vJEF.jpg',
                'image4' => NULL,
                'image5' => NULL,
                'image6' => NULL,
                'main_image' => 'variant_1606208724wgDCM5uiIg.png',
                'var_id' => 5,
                'created_at' => '2020-11-24 14:35:25',
                'updated_at' => '2020-11-24 14:35:25',
            ),
            5 => 
            array (
                'id' => 6,
                'image1' => 'variant_1606208872V5Ucewue9H.jpg',
                'image2' => 'variant_1606208872mmtXXPz8NC.jpg',
                'image3' => NULL,
                'image4' => 'variant_1606208872O2LrT7wV1i.jpg',
                'image5' => NULL,
                'image6' => NULL,
                'main_image' => 'variant_1606208872V5Ucewue9H.jpg',
                'var_id' => 6,
                'created_at' => '2020-11-24 14:37:52',
                'updated_at' => '2020-11-24 14:37:52',
            ),
        ));
        
        
    }
}