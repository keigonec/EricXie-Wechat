<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 接收普通消息时，各消息类型的推送XML数据包结构
 *
 * Last Modified Time: 2016-02-17 23:53:15
 */

namespace ericxie\wechat\traits\msg;

use Yii;

trait ReceiveMsgStru
{
    private function _getReceiveMsgStru($type = '')
    {
        /*
        1 文本消息 --> text
        2 图片消息 --> image
        3 语音消息 --> voice
        4 视频消息 --> video
        5 小视频消息 --> shortvideo
        6 地理位置消息 --> location
        7 链接消息 --> link
         */
        $msgTpl = [
                    'text' => ["ToUserName","FromUserName","CreateTime","MsgType","Content","MsgId"],
                    'image' => ["ToUserName","FromUserName","CreateTime","MsgType","PicUrl","MediaId","MsgId"],
                    'voice' => ["ToUserName","FromUserName","CreateTime","MsgType","MediaId","Format","Recognition","MsgId"],
                    'video' => ["ToUserName","FromUserName","CreateTime","MsgType","MediaId","ThumbMediaId","MsgId"],
                    'shortvideo' => ["ToUserName","FromUserName","CreateTime","MsgType","MediaId","ThumbMediaId","MsgId"],
                    'location' => ["ToUserName","FromUserName","CreateTime","MsgType","Location_X","Location_Y","Scale","Label","MsgId"],
                    'link' => ["ToUserName","FromUserName","CreateTime","MsgType","Title","Description","Url","MsgId"]
                ];
        return (($type != '') && isset($msgTpl[$type])) ? $msgTpl[$type] : $msgTpl;
    }
}

?>