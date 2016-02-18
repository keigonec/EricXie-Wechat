<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 消息管理（包含普通消息，事件等）
 *
 * Last Modified Time: 2016-02-18 00:50:21
 */

namespace ericxie\wechat\traits;

use ericxie\wechat\traits\msg\ReceiveEventStru;
use ericxie\wechat\traits\msg\ReceiveMsgStru;
use ericxie\wechat\traits\msg\SendMsgTpl;
use ericxie\wechat\traits\msg\SendMsgParaCheck;

trait Msg
{
    /*
        接收事件推送，各事件类型的推送XML数据包结构
     */
    use ReceiveEventStru;
    /*
        接收普通消息时，各消息类型的推送XML数据包结构
     */
    use ReceiveMsgStru;
    /*
        被动回复用户消息时，各消息类型的推送XML数据模板
     */
    use SendMsgTpl;
    /*
        被动回复用户消息时，各消息类型的推送XML数据模板对应参数检查
     */
    use SendMsgParaCheck;

    public function ReadMsg()
    {
        //获取微信发送的消息
        $postStr = $this->getMsgContents();

        if (!empty($postStr))
        {
            $para = [];
            $postObj = $this->xmlToObj($postStr);

            if(!empty($postObj))
            {
                $this->_msgType = (string)$postObj->MsgType;

                //消息类型判断
                if(in_array($this->_msgType, array_keys($this->_Receive_Msg_Stru)))
                {
                    //读取消息信息
                    foreach ($this->_Receive_Msg_Stru[$this->_msgType] as $v)
                    {
                        $para[$v] = isset($postObj->$v) ? trim((string)$postObj->$v) : '';
                    }

                    $this->_setData($para);
                }
                else
                {
                    //事件类型判断
                    if($this->_msgType == 'event')
                    {
                        $this->_eventType = (string)$postObj->Event;

                        //读取事件信息
                        if(in_array($this->_eventType, array_keys($this->_Receive_Event_Stru)))
                        {
                            foreach ($this->_Receive_Event_Stru[$this->_eventType] as $v)
                            {
                                $para[$v] = isset($postObj->$v) ? trim((string)$postObj->$v) : '';
                            }

                            $this->_setData($para);
                        }
                        else
                        {
                            $this->_setError(WECHATMSG_READ_EVENTTYPE_INVALID);
                        }
                    }
                    else
                    {
                        $this->_setError(WECHATMSG_READ_MSGTYPE_INVALID);
                    }
                }
            }
        }
        else
        {
            $this->_setError(WECHATMSG_READ_MSG_EMPTY);
        }
    }

    public function SendMsg($msgType = 'text', $data = [])
    {
        $msgType = strtolower($msgType);
        $action = '_get' . ucfirst($msgType) . 'tpl';
        $action = method_exists($this,$action) ? $action : false;

        if($action)
        {
            $this->_feedback = $this->$action($data);
        }
        else
        {
            $this->_setError(WECHATMSG_READ_MSGTYPE_INVALID);
        }
    }
}

?>