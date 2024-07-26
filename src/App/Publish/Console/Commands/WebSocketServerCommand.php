<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-16 15:00:36
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-17 02:59:10
 * @FilePath: \app\Console\Commands\WebSocketServerCommand.php
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Facade\Phone\Websocket\PhoneSocketFacade;

class WebSocketServerCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start the WebSocket server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         /* $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            8080
        );

        $server->run(); */

        PhoneSocketFacade::init();
    }
}
