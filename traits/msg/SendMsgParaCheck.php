<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 被动回复用户消息时，各消息类型的推送XML数据模板对应参数检查
 *
 * Last Modified Time: 2016-02-18 00:47:45
 */

namespace ericxie\wechat\traits\msg;

use Yii;

trait SendMsgParaCheck
{
    /*
        回复文本消息时对应参数检查
    */
    private function _getTextTplPara(&$Content)
    {
        $Content = is_array($Content) ? reset($Content) : $Content;
    }

    /*
        回复图片消息时对应参数检查
    */
    private function _getImageTplPara(&$MediaId)
    {
        $MediaId = is_array($MediaId) ? reset($MediaId) : $MediaId;
    }

    /*
        回复语音消息时对应参数检查
    */
    private function _getVoiceTplPara(&$MediaId)
    {
        $MediaId = is_array($MediaId) ? reset($MediaId) : $MediaId;
    }

    /*
        回复视频消息时对应参数检查
    */
    private function _getVideoTplPara(&$para)
    {
        if(!is_array($para))
        {
            $para = ['MediaId' => '','Title' => '','Description' => ''];
        }
    }

    /*
        回复音乐消息时对应参数检查
    */
    private function _getMusicTplPara(&$para)
    {
        if(!is_array($para))
        {
            $para = ['Title' => '','Description' => '','MusicUrl' => '','HQMusicUrl' => '','ThumbMediaId' => ''];
        }
    }

    /*
        回复图文消息时对应参数检查
    */
    private function _getNewsTplPara(&$para)
    {
        if(!is_array($para))
        {
            $para = [['Title' => '','Description' => '','PicUrl' => '','Url' => '']];
        }
    }
}

?>