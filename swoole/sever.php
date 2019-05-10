<?php
// Server
class Server
{
    private $serv;

    public function __construct() {
        //实例化一个swoole对象 绑定ip和端口
        $this->serv = new swoole_server("0.0.0.0", 9501);
        //设置swoole对象的参数
        $this->serv->set(array(
            'worker_num' => 3,
            'daemonize' => false,
            'max_request' => 10000,
            'dispatch_mode' => 2,
            'debug_mode'=> 1
        ));
        //设置回调
        $this->serv->on('Start', array($this, 'onStart'));
        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Close', array($this, 'onClose'));
        //开启服务
        $this->serv->start();
    }
    //服务开启会调用此方法
    public function onStart( $serv ) {
        echo "Start\n";
    }
    //当客户端连接服务器端的时候会回调此方法
    public function onConnect( $serv, $fd, $from_id ) {
        $serv->send( $fd, "Hello {$fd}!" );
    }
    //当服务器端收到客户端发送的消息会回调此方法
    public function onReceive( swoole_server $serv, $fd, $from_id, $data ) {
        echo "Get Message From Client {$fd}:{$data}\n";
    }
    //当客户端断开连接会回调这个方法
    public function onClose( $serv, $fd, $from_id ) {
        echo "Client {$fd} close connection\n";
    }
}
// 启动服务器
$server = new Server();
