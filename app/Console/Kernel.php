<?php

namespace App\Console;

use App\Console\Commands\CacheClear;
use App\Console\Commands\PurchaseCopy;
use App\Jobs\WalletExpire;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \Torann\Currency\Console\Update::class,
        \Torann\Currency\Console\Cleanup::class,
        \Torann\Currency\Console\Manage::class,
         Commands\BackgroundTask::class,
         CacheClear::class,
         PurchaseCopy::class,
         Commands\ImportDemo::class,
         Commands\MakeZip::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        
        

        // $schedule->command('test:c')->daily()->withoutOverlapping(1)->timezone('Asia/Calcutta');
        
        // $schedule->command('test:c')->dailyAt('11:39')->withoutOverlapping(1)->timezone('Asia/Calcutta');

        $schedule->job(new WalletExpire)->daily()->timezone(env('TIMEZONE','UTC'));

        // $schedule->command('test:c')->between('12:02', '1:00')->withoutOverlapping(1)->timezone('Asia/Calcutta');

        $schedule->command('backgroundsync:cron')
        ->everyMinute()
        ->timezone(env('TIMEZONE','UTC'));
     
       
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
