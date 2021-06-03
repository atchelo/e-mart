<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class CacheClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:optimize';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'It will clear all the cache of views/session/logs from storage folder';

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

        $this->info('Optimizing app. Please wait as it can take a while...');
       
        Artisan::call('view:cache');
        Artisan::call('view:clear');
        Artisan::call('route:clear');

        $this->info('App optimized successfully !');

        $dir = base_path().'/storage/framework/sessions';

        foreach (glob("$dir/*") as $file) {
           
            unlink($file);
            
        }

        $dir2 = base_path().'/storage/logs';
        $leave_files = array('.gitignore');

        foreach (glob("$dir2/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                unlink($file);
            }
        }

        $dir3 = base_path().'/storage/debugbar';
        $leave_files = array('.gitignore');

        foreach (glob("$dir3/*") as $file) {
            if (!in_array(basename($file), $leave_files)) {
                unlink($file);
            }
        }

        $dir4 = base_path().'/storage/dotenv-editor/backups/';
        

        foreach (glob("$dir4/*") as $file) {
            
            unlink($file);
            
        }

        $this->info('Task done !');

        return 0;

    }
}
