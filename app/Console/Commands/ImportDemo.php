<?php

namespace App\Console\Commands;

use App\Cart;
use Illuminate\Console\Command;
use Artisan;
use ZipArchive;

class ImportDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:demo';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will import demo on your script !';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Importing Demo...');

        Cart::truncate();

        

        Artisan::call('db:seed --class=AddProductVariantsTableSeeder');
        Artisan::call('db:seed --class=AddressesTableSeeder');
        Artisan::call('db:seed --class=AddSubVariantsTableSeeder');
        Artisan::call('db:seed --class=AdvsTableSeeder');
        Artisan::call('db:seed --class=BlogsTableSeeder');
        Artisan::call('db:seed --class=BrandsTableSeeder');
        Artisan::call('db:seed --class=CanceledOrdersTableSeeder');
        Artisan::call('db:seed --class=CategoriesTableSeeder');

        Artisan::call('db:seed --class=CategorySlidersTableSeeder');
        Artisan::call('db:seed --class=CoupansTableSeeder');
        Artisan::call('db:seed --class=FaqsTableSeeder');
        Artisan::call('db:seed --class=FootersTableSeeder');
        Artisan::call('db:seed --class=FrontCatsTableSeeder');
        Artisan::call('db:seed --class=MenusTableSeeder');
        Artisan::call('db:seed --class=FooterMenusTableSeeder');
        
        Artisan::call('db:seed --class=GrandcategoriesTableSeeder');
        Artisan::call('db:seed --class=HotdealsTableSeeder');
        Artisan::call('db:seed --class=InvoiceDownloadsTableSeeder');
        Artisan::call('db:seed --class=OrdersTableSeeder');

         Artisan::call('db:seed --class=PagesTableSeeder');
         Artisan::call('db:seed --class=ProductAttributesTableSeeder');
         Artisan::call('db:seed --class=ProductsTableSeeder');
         Artisan::call('db:seed --class=ProductValuesTableSeeder');
         Artisan::call('db:seed --class=SlidersTableSeeder');
         Artisan::call('db:seed --class=OrderActivityLogsTableSeeder');
         Artisan::call('db:seed --class=SubcategoriesTableSeeder');

         Artisan::call('db:seed --class=TestimonialsTableSeeder');
         Artisan::call('db:seed --class=VariantImagesTableSeeder');

         

        ini_set('max_execution_time', 200);

        $file = public_path().'/democontent.zip'; 
        
        $this->info('Extracting demo contents...');

        try{
                //create an instance of ZipArchive Class
            $zip = new ZipArchive;
             
            //open the file that you want to unzip. 
            //NOTE: give the correct path. In this example zip file is in the same folder
            $zipped = $zip->open($file);
             
            // get the absolute path to $file, where the files has to be unzipped
            $path = public_path();
             
            //check if it is actually a Zip file
            if ($zipped) {
                //if yes then extract it to the said folder
              $extract = $zip->extractTo($path);

              //close the zip
              $zip->close();  
             
              //if unzipped succesfully then show the success message
              if($extract){
                 $this->info('Demo data imported successfully !');
                 Artisan::call('key:generate');
              }
            }
        }catch(\Exception $e){
            die($e->getMessage());
        }


        
    }
}
