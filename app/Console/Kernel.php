<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // 微信发送上课提醒
        \App\Console\Commands\SendStartMassage::class,
        // 处理完课
        \App\Console\Commands\AfterClass::class,
    ];


	
	
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
           $schedule->command('SendStartMassage')->dailyAt('10:00');// 每天10:00运行一次...
           $schedule->command('AfterClass')
           			->everyThirtyMinutes()
           			->between('9:15', '21:15');// 每天9:15~21:15 每半小时运行一次        
    }
    


    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
