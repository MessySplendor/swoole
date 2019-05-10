<?php
class Client
{
    private $client;

    public function __construct() {
        //创建一个客户端
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
    }

    public function connect() {
        //连接服务器
        if( !$this->client->connect("127.0.0.1", 9501 , 1) ) {
            echo "Error: {$fp->errMsg}[{$fp->errCode}]\n";
        }
        //接收消息
        $message = $this->client->recv();
        echo "Get Message From Server:{$message}\n";

        fwrite(STDOUT, "请输入消息：");
        $msg = trim(fgets(STDIN));
        //发送消息
        $this->client->send( $msg );
    }
}

$client = new Client();
$client->connect();
