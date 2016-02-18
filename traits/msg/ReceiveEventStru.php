<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 接收事件推送，各事件类型的推送XML数据包结构
 *
 * Last Modified Time: 2016-02-17 23:52:20
 */

namespace ericxie\wechat\traits\msg;

use Yii;

trait ReceiveEventStru
{
    private function _getReceiveEventStru($type = '')
    {
        /*
        1 关注/取消关注事件 --> subscribe / unsubscribe
        2 扫描带参数二维码事件 --> SCAN
        3 上报地理位置事件 --> LOCATION
        4 自定义菜单事件 --> 无事件推送
        5 点击菜单拉取消息时的事件推送 --> CLICK
        6 点击菜单跳转链接时的事件推送 --> VIEW
         */
        $eventTpl = [
                    'subscribe' => ["ToUserName","FromUserName","CreateTime","MsgType","Event","EventKey","Ticket"],
                    'unsubscribe' => ["ToUserName","FromUserName","CreateTime","MsgType","Event"],
                    'SCAN' => ["ToUserName","FromUserName","CreateTime","MsgType","Event","EventKey","Ticket"],
                    'LOCATION' => ["ToUserName","FromUserName","CreateTime","MsgType","Event","Latitude","Longitude","Precision"],
                    'CLICK' => ["ToUserName","FromUserName","CreateTime","MsgType","Event","EventKey"],
                    'VIEW' => ["ToUserName","FromUserName","CreateTime","MsgType","Event","EventKey"]
                ];
        return (($type != '') && isset($eventTpl[$type])) ? $eventTpl[$type] : $eventTpl;
    }
}

?>