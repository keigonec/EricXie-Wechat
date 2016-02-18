<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 为Yii2实现的微信开发基础类
 *
 * Last Modified Time: 2016-02-18 00:53:40
 */
namespace ericxie\wechat;

use ericxie\wechat\traits\Config;
use ericxie\wechat\traits\Error;
use ericxie\wechat\traits\Check;
use ericxie\wechat\traits\Getset;
use ericxie\wechat\traits\Utils;
use ericxie\wechat\traits\Token;
use ericxie\wechat\traits\Security;
use ericxie\wechat\traits\Msg;

class Wechat
{
    /*
        参数设置(常量和类变量)
     */
    use Config;

    /*
        错误编码和信息
     */
    use Error;

    /*
        错误编码和信息
     */
    use Check;

    /*
        变量Get & Set
     */
    use Getset;

    /*
        工具集合
     */
    use Utils;

    /*
        Token集合
     */
    use Token;

    /*
        安全相关
     */
    use Security;

    /*
        消息管理（包含普通消息，事件等）
     */
    use Msg;

    public function __construct($appid = '', $appsecret = '', $tokencache = 'file', $lang = 'chs')
    {
        $this->_Token_Cache = in_array(strtolower($tokencache), ['file', 'memcache', 'redis']) ? strtolower($tokencache) : 'file';
        $this->_Token_Key = md5(APP_NAME . $appid . $appsecret);
        $this->_lang = $lang;

        $this->_selfcheck();
        $this->_Wx_Token = $this->_getAccessToken($appid, $appsecret);

        $this->_Receive_Msg_Stru = $this->_getReceiveMsgStru();
        $this->_Receive_Event_Stru = $this->_getReceiveEventStru();
        $this->_Send_Msg_Tpl = $this->_getSendMsgTpl();
    }

    public function Run($token = '')
    {
        if($token != '')
        {
            $this->_Wx_Token = $token;
        }

        $echoStr = (isset($_GET['echostr']) && !empty($_GET['echostr'])) ? $_GET['echostr'] : '';

        if($this->checkSignature($token))
        {
            echo $echoStr;
        }
        else
        {
            echo 'echostr invalid';
        }
        exit;
    }

    private function checkSignature($token)
    {
        $_Wx_Timestamp = (isset($_GET['timestamp']) && !empty($_GET['timestamp'])) ? $_GET['timestamp'] : '';
        $_Wx_Nonce = (isset($_GET['nonce']) && !empty($_GET['nonce'])) ? $_GET['nonce'] : '';
        $_Wx_Signature = (isset($_GET['signature']) && !empty($_GET['signature'])) ? $_GET['signature'] : '';

        $tmpArr = array($token, $_Wx_Timestamp, $_Wx_Nonce);

        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if($tmpStr == $_Wx_Signature)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}