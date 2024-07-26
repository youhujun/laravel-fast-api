<?php
/*
 * @Descripttion:
 * @version: v1
 * @Author: youhujun 2900976495@qq.com
 * @Date: 2024-07-16 10:50:14
 * @LastEditors: youhujun 2900976495@qq.com
 * @LastEditTime: 2024-07-16 20:04:44
 * @FilePath: \app\Service\Facade\Phone\Websocket\PhoneSocketFacadeService.php
 */

namespace App\Service\Facade\Phone\Websocket;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use Swoole\WebSocket\Server;

use App\Facade\Phone\Websocket\User\PhoneSocketUserFacade;

/**
 * @see \App\Facade\Phone\Websocket\PhoneSocketFacade
 */
class PhoneSocketFacadeService
{
   public function test()
   {
       echo "PhoneSocketFacadeService test";
   }

     //websocket server 对象sss
   private $sever;

   //客户端链接容器
   protected $clients = [];

   protected $port;

   public function __construct()
   {
	   $this->port = config('custom.websocket_port');
       echo "端口号:{$this->port}\r\n";
   }

   /**
    * 初始化
    */
   public function init()
   {
        $this->server = new Server('0.0.0.0', $this->port);

        //监听WebSocket连接打开事件
        $this->server->on('Open', function ($webSocket, $frame)
        {
            //p($frame->fd);
            echo "Open-{$frame->fd}\n";

            $message = ['code'=>0,'msg'=>'connect open'];
            $this->clients[$frame->fd] = $webSocket;
            $this->clients[$frame->fd]->push($frame->fd, \json_encode($message));
        });

        //监听WebSocket消息事件
        $this->server->on('Message', function ($webSocket, $frame)
        {
             echo "Message-{$frame->data}\n";
             // 前端统一用 Json.stringify() 后端解析为数组
             $data = \json_decode($frame->data,true);

             if(isset($data['type']) && isset($data['token']))
             {
                ['type'=>$type,'token'=>$token] = $data;
                //10 表示客户端登录后 存储 用户user_id
                if($data['type'] == 10)
                {
                     ['user_id'=>$user_id] =$data;

                    $message = ['code'=>0,'msg'=>"user_id-{$user_id}:socket用户登录失败",'error'=>'socketUserLoginError'];

                    $checkResult = PhoneSocketUserFacade::checkSocketUserIsLogin($user_id,$token);

                    if($checkResult)
                    {
                       $saveResult =  PhoneSocketUserFacade::saveSocketUser($user_id,$frame->fd);

                       if($saveResult)
                       {
                            $message = ['code'=>0,'event'=>10,'msg'=>"save user_id-{$user_id}-success"];
                       }
                    }
                }

                $this->clients[$frame->fd] = $webSocket;
                $this->clients[$frame->fd]->push($frame->fd, \json_encode($message));
             }

        });

        //监听WebSocket连接关闭事件
        $this->server->on('Close', function ($webSocket, $fd)
        {
            echo "client-{$fd} is closed\n";
            unset( $this->clients[$fd]);
        });

        //监听请求 配合后端主动推送消息
        $this->server->on('Request', function ($request, $response)
         {
            $data = $request->post;

            if(isset($data['send_type']) && !is_null($data['send_type']))
            {
                // $msg = $request->post['message'];

                $message = \json_encode($data);

                if($data['send_type'] == 10)
                {
                    // 接收http请求从get获取message参数的值，给用户推送
                    // $this->server->connections 遍历所有websocket连接用户的fd，给所有用户推送
                    foreach ($this->server->connections as $fd)
                    {
                        echo "All-Request\n";
                        // 需要先判断是否是正确的websocket连接，否则有可能会push失败
                        if ($this->server->isEstablished($fd))
                        {
                            $this->server->push($fd, $message);
                        }
                    }
                }

                //只对特定发送
                if($data['send_type'] == 20)
                {
                    $fd = Redis::hget('socket:socket',$data['user_id']);

                    //p($fd);

                    if($fd)
                    {
                         $this->clients[$fd]->push($fd, $message);
                    }
                    else
                    {
                        Log::debug(['$fd'=>"存储的链接丢失"]);
                    }


                }

            }

        });

        //只有非 WebSocket 连接关闭时才会触发该事件。
        $this->server->on('Disconnect',function($webSocket, $fd)
        {
            echo "client-{$fd} is disconnect\n";
        });

        $this->server->start();
   }

   /**
    *
    *
    * @param  [type] $data
    $data = [];
    $data['user_id'] = $user->id;
    //10 所有人 20只对某一个用户 30 对某一些用户
    $data['send_type'] = 10;
    $data['code'] = 0;
    //事件对应操作 10表示存储socket用户登录id
    $data['event'] = 10;
    //返回信息
    $data['msg'] = '主动推送消息'.date("Y-m-d H:i:s");
    PhoneSocketFacade::curl($data);
    */
    public function curl($data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, "http://127.0.0.1:{$this->port}");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_exec($curl);
        curl_close($curl);
    }

}
