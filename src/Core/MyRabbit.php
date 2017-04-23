<?php
/**
 * Created by PhpStorm.
 * User: Hacker
 * Date: 2017/04/23
 * Time: 22:31
 */

namespace Hanson\Vbot\Core;

class MyRabbit
{

    static $instance;

    protected $conn = null;
    protected $channel = null;
    protected $ex = null;

    public function __construct()
    {
        $this->init();
    }

    /**
     * Init rabbitmq
     */
    private function init()
    {
        //设置连接
        $conn_args = array( 'host'=>'114.55.133.164' , 'port'=> '5672', 'login'=>'rabbit' , 'password'=> 'Rbtr@esit445','vhost' =>'/');
        $this->conn = new \AMQPConnection($conn_args);
        $this->conn->connect();
        //创建channel
        $this->channel = new \AMQPChannel($this->conn);
        //创建exchange
        $this->ex = new \AMQPExchange($this->channel);
        $this->ex->setName('robot_exchange');//创建名字
        $this->ex->setType(AMQP_EX_TYPE_DIRECT);
        $this->ex->setFlags(AMQP_DURABLE);
        $this->ex->declareExchange();
    }

    /**
     * @return MyRabbit
     */
    public static function getInstance()
    {
        if(!static::$instance){
            static::$instance = new MyRabbit();
        }

        return static::$instance;
    }

    /**
     * publish message
     */
    public function publish($message, $routingkey='robot_key')
    {
        is_string($message) or $message=json_encode($message);
        $this->ex->publish($message,$routingkey);
    }
}