<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 参数设置(常量和类变量)
 *
 * Last Modified Time: 2016-02-18 00:50:22
 */

namespace ericxie\wechat\traits;

define('APP_NAME', 'EricXie-Wechat');
define('WECHAT_VERSION', 'Ver0.1');
define('WECHAT_DEFAULT_TOKEN', 'EricXie');

define('URL_ACCESSTOKEN', 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s');
define('URL_SERVERS', 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=%s');
define('TOKEN_LIFE_RESERVE', 180);

trait Config
{
    //微信Access Token，缓存Token的方法，缓存Token的键值
    private $_Wx_Token, $_Token_Cache, $_Token_Key;

    //接收普通消息：各消息类型的推送XML数据包结构
    private $_Receive_Msg_Stru;

    //接收事件推送：各事件类型的推送XML数据包结构
    private $_Receive_Event_Stru;

    //发送消息：各消息类型的推送数据包结构
    private $_Send_Msg_Tpl;

    //服务号变量，用户变量
    private $_Service_Id, $_User_Id;

    //Msg类的状态变量，错误编码变量，错误信息变量，返回数据变量，语言变量
    private $_status, $_errorCode, $_errorMsg, $_data, $_lang;

    //接收到普通消息的类别变量，接收事件推送的类别变量，用于返回的临时变量
    private $_msgType, $_eventType, $_feedback;

    public function status()
    {
        return [
            'Token' => $this->_Wx_Token,
            'Info' => [
                'Service_Id' => $this->_Service_Id,
                'User_Id' => $this->_User_Id,
                'Msg_Type' => $this->_msgType,
                'Language' => $this->_lang
            ],
            'Status' => [
                'status' => $this->_status,
                'errorCode' => $this->_errorCode,
                'errorMsg' => $this->_errorMsg,
            ],
            'Data' => $this->_data,
            'Feedback' => $this->_feedback,
            'Stru&Tpl' => [
                'Receive_Msg_Stru' => $this->_Receive_Msg_Stru,
                'Receive_Event_Stru' => $this->_Receive_Event_Stru,
                'Send_Msg_Tpl' => $this->_Send_Msg_Tpl,
            ],
        ];
    }
}

?>