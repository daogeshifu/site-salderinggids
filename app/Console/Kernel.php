<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('app:process-lunwen-tasks')->everyMinute();
        // 翻译文章每天翻译一次
        $schedule->command('translate:articles --limit=5 --method=api')->daily();
        // 生成 sitemap 每天生成一次，放在文章翻译任务之后，避免同一时间并发执行
        $schedule->command('sitemap:generate --base-url=https://www.hellogeo.ai')->dailyAt('00:30')->withoutOverlapping();
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
