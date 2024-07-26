<?php
/*
 * @Descripttion: 
 * @version: 
 * @Author: YouHuJun
 * @Date: 2022-02-09 13:42:27
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-03-02 11:29:55
 */


namespace YouHuJun\LaravelFastApi\App\Console\Commands;

use Illuminate\Console\Command;

class CallFacadeServiceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:facade {facadeName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "call create facade and it's service command ";

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
     * @return mixed
     */
    public function handle()
    {
        $param = $this->argument('facadeName');

        $this->call('make:facade', [
            'name' => $param
        ]);

        $this->call('facade:service', [
            'name' => $param
        ]);
        
    }
}
