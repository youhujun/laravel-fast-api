<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-17 03:05:03
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 03:37:44
 * @FilePath: \app\Console\Commands\ExecuteTotalCommand.php
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Facade\Common\Total\TotalAllDataFacade;

class ExecuteTotalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'execute:total';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'implement data statistics';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //执行所有统计
        TotalAllDataFacade::doAllTotal();
    }
}
