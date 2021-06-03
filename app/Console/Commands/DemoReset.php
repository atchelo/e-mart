<?php

namespace App\Console\Commands;

use App\AddProductVariant;
use App\Address;
use App\AddSubVariant;
use App\Adv;
use App\Blog;
use App\Brand;
use App\CanceledOrders;
use App\Cart;
use App\Category;
use App\CategorySlider;
use App\Coupan;
use App\Faq;
use App\FooterMenu;
use App\FrontCat;
use App\Grandcategory;
use App\Hotdeal;
use App\InvoiceDownload;
use App\Menu;
use App\Order;
use App\OrderActivityLog;
use App\Page;
use App\Product;
use App\ProductAttributes;
use App\ProductValues;
use App\Slider;
use App\Subcategory;
use App\Testimonial;
use App\VariantImages;
use Illuminate\Console\Command;

class DemoReset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will reset your demo !';

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

        try {
            
            $this->info('Demo is resetting...');

            AddSubVariant::truncate();
            AddProductVariant::truncate();
            Address::truncate();
            Adv::truncate();
            Blog::truncate();
            Brand::truncate();
            CanceledOrders::truncate();
            Category::truncate();
            CategorySlider::truncate();
            Cart::truncate();
            Coupan::truncate();
            Faq::truncate();

            $this->info('30% done...');

            FrontCat::truncate();
            Grandcategory::truncate();
            Hotdeal::truncate();
            InvoiceDownload::truncate();
            Order::truncate();

            $leave_files = array('index.php');

            $dir0 = public_path() . '/variantimages/thumbnails';

            foreach (glob("$dir0/*") as $file) {

                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }

            }

            $dir1 = public_path() . '/variantimages/hoverthumbnail';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir1/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }

            }

            $dir = public_path() . '/variantimages/';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir2 = public_path() . '/images/blog';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir2/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir3 = public_path() . '/images/brands';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir3/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir4 = public_path() . '/images/category';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir4/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir5 = public_path() . '/images/detailads';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir5/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir6 = public_path() . '/images/grandcategory';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir6/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir8 = public_path() . '/images/layoutads';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir8/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir12 = public_path() . '/images/slider';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir12/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            Page::truncate();
            ProductAttributes::truncate();
            Product::truncate();
            ProductValues::truncate();
            Menu::truncate();
            FooterMenu::truncate();

            $this->info('70% done...');

            $dir14 = public_path() . '/images/subcategory';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir14/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $dir15 = public_path() . '/images/testimonial';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir15/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            Slider::truncate();
            OrderActivityLog::truncate();
            Subcategory::truncate();
            Testimonial::truncate();
            VariantImages::truncate();

            $dir17 = public_path() . '/images/videothumbnails';

            // $leave_files = array('.gitignore');

            foreach (glob("$dir17/*") as $file) {
                if (!in_array(basename($file), $leave_files)) {
                    try {
                        unlink($file);
                    } catch (\Exception $e) {

                    }
                }
            }

            $this->info('100% done...');

            $this->info('Demo Reset Successfully !');
            \Artisan::call('key:generate');
        } catch (\Exception $e) {
            die('Database connection is not OK check .env file for more....');
        }

    }
}
