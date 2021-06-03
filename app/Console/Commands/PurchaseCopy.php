<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PurchaseCopy extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will create a new copy and reset everything (ONLY FOR DEVELOPERS).';

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
        $this->info("Making Purchase copy... Please wait it can take more time.");
       

        $leave_files = array('index.php');

        $dir0 = public_path().'/variantimages/thumbnails';

        foreach (glob("$dir0/*") as $file) {
            
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
            
        }

        $this->info("::::::::::::: 10% ::::::::::::");

        $dir1 = public_path().'/variantimages/hoverthumbnail';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir1/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
            
        }

        $dir = public_path().'/variantimages/';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $this->info("::::::::::::: 20% ::::::::::::");

        $dir2 = public_path().'/images/blog';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir2/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir3 = public_path().'/images/brands';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir3/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir4 = public_path().'/images/category';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir4/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir5 = public_path().'/images/detailads';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir5/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir6 = public_path().'/images/grandcategory';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir6/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir7 = public_path().'/images/helpDesk';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir7/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $this->info("::::::::::::: 40% ::::::::::::");

        $dir8 = public_path().'/images/layoutads';

        

        // $leave_files = array('.gitignore');

        foreach (glob("$dir8/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir9 = public_path().'/images/menu';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir9/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir10 = public_path().'/images/seal';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir10/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir11 = public_path().'/images/sign';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir11/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir12 = public_path().'/images/slider';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir12/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir13 = public_path().'/images/store';

        $this->info("::::::::::::: 60% ::::::::::::");

        // $leave_files = array('.gitignore');

        foreach (glob("$dir13/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir14 = public_path().'/images/subcategory';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir14/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir15 = public_path().'/images/testimonial';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir15/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir16 = public_path().'/images/user';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir16/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

       

        $dir17 = public_path().'/images/videothumbnails';

        // $leave_files = array('.gitignore');

        foreach (glob("$dir17/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir18 = public_path().'/images/manual_payment';

        foreach (glob("$dir18/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $dir19 = public_path().'/images/purchase_proof';

        foreach (glob("$dir19/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                try{
                    unlink($file);
                }catch(\Exception $e){

                }
            }
        }

        $this->info("::::::::::::: 100% ::::::::::::");

        $remove_step_files = array('step1.txt', 'step2.txt', 'step3.txt', 'step4.txt', 'step5.txt', 'step6.txt', 'step7.txt', 'draft.txt','info.txt','config.txt','sitemap.xml');

        foreach ($remove_step_files as $key => $file) {

            try{
                unlink(public_path(). '/' . $file);
            }catch(\Exception $e){

            }

        }

        $this->info("Purchase copy completed successfully.");

    }
}
