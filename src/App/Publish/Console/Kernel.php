<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-04-06 14:57:45
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-21 07:41:07
 * @FilePath: d:\wwwroot\Working\PHP\Components\Laravel\youhujun\laravel-fast-api-base\src\App\Publish\Console\Kernel.php
 */

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use App\Console\Commands\ExecuteTotalCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();

        //数据库备份
        $this->mysqlBak($schedule);

        //测试用
        //$schedule->command(ExecuteTotalCommand::class)->everyThreeMinutes();

       // $schedule->command(ExecuteTotalCommand::class)->dailyAt('5:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }

    /**
     * 数据库备份
     *
     * @param Schedule $schedule
     * @return void
     */
    public function mysqlBak(Schedule $schedule)
    {

         //每天凌晨零点40执行数据库备份
         // $schedule->exec('source 绝对路径/cron/mysql_bak.sh')->dailyAt('00:40')->timezone('Asia/Shanghai');
    }
}
