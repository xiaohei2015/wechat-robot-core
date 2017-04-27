<?php
/**
 * Created by PhpStorm.
 * User: HanSon
 * Date: 2016/12/7
 * Time: 16:33
 */

require_once __DIR__ . './../vendor/autoload.php';

use Hanson\Vbot\Foundation\Vbot;
use Hanson\Vbot\Message\Entity\Message;
use Hanson\Vbot\Message\Entity\Image;
use Hanson\Vbot\Message\Entity\Text;
use Hanson\Vbot\Message\Entity\Emoticon;
use Hanson\Vbot\Message\Entity\Location;
use Hanson\Vbot\Message\Entity\Video;
use Hanson\Vbot\Message\Entity\Voice;
use Hanson\Vbot\Message\Entity\Recall;
use Hanson\Vbot\Message\Entity\RedPacket;
use Hanson\Vbot\Message\Entity\Transfer;
use Hanson\Vbot\Message\Entity\Recommend;
use Hanson\Vbot\Message\Entity\Share;
use Hanson\Vbot\Message\Entity\Official;
use Hanson\Vbot\Message\Entity\Touch;
use Hanson\Vbot\Message\Entity\Mina;
use Hanson\Vbot\Message\Entity\RequestFriend;
use Hanson\Vbot\Message\Entity\GroupChange;
use Hanson\Vbot\Message\Entity\NewFriend;
use Hanson\Vbot\Support\Console;

$path = __DIR__ . '/./../tmp/';
$robot = new Vbot([
    'tmp' => $path,
    'debug' => true
]);

// 图灵自动回复
function reply($str){
    return http()->post('http://www.tuling123.com/openapi/api', [
        'key' => '1dce02aef026258eff69635a06b0ab7d',
        'info' => $str
    ], true)['text'];

}

$robot->server->setMessageHandler(function ($message) use ($path) {
    /** @var $message Message */

    // 位置信息 返回位置文字
    if ($message instanceof Location) {
        /** @var $message Location */
        Text::send('地图链接：'.$message->from['UserName'], $message->url);
        return '位置：'.$message;
    }

    // 文字信息
    if ($message instanceof Text) {
        /** @var $message Text */
        // 联系人自动回复
        if ($message->fromType === 'Contact') {
	    	echo $message->content.PHP_EOL;
            return reply($message->content);
            // 群组@我回复
        } elseif ($message->fromType === 'Group' && $message->isAt) {
            return reply($message->content);
        }
    }

    // 手机点击聊天事件
    /*if($message instanceof Touch){
        Text::send($message->msg['ToUserName'], "我点击了此聊天");
    }*/

    return false;

});

$robot->server->setExitHandler(function(){
    \Hanson\Vbot\Support\Console::log('其他设备登录');
});

$robot->server->setExceptionHandler(function(){
    \Hanson\Vbot\Support\Console::log('异常退出');
});

$robot->server->run();
