<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 被动回复用户消息时，各消息类型的推送XML数据模板
 *
 * Last Modified Time: 2016-02-18 00:53:45
 */

namespace ericxie\wechat\traits\msg;

use Yii;

trait SendMsgTpl
{
    /*
        消息模板列表
    */
    private function _getSendMsgTpl()
    {
        return 'SendMsgTpl';
    }

    /*
        回复文本消息
    */
    private function _getTextTpl($Content = '')
    {
        $check = __FUNCTION__ . 'Para';
        $this->$check($Content);

        $tpl = '<xml>
                <ToUserName><![CDATA[' . $this->_User_Id . ']]></ToUserName>
                <FromUserName><![CDATA[' . $this->_Service_Id . ']]></FromUserName>
                <CreateTime>' . time() . '</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                </xml>';

        $feedback = sprintf($tpl, $Content);

        return $feedback;
    }

    /*
        回复图片消息
    */
    private function _getImageTpl($MediaId = '')
    {
        $check = __FUNCTION__ . 'Para';
        $this->$check($MediaId);

        $tpl = '<xml>
                <ToUserName><![CDATA[' . $this->_User_Id . ']]></ToUserName>
                <FromUserName><![CDATA[' . $this->_Service_Id . ']]></FromUserName>
                <CreateTime>' . time() . '</CreateTime>
                <MsgType><![CDATA[image]]></MsgType>
                <Image>
                <MediaId><![CDATA[%s]]></MediaId>
                </Image>
                </xml>';

        $feedback = sprintf($tpl, $MediaId);

        return $feedback;
    }

    /*
        回复语音消息
    */
    private function _getVoiceTpl($MediaId = '')
    {
        $check = __FUNCTION__ . 'Para';
        $this->$check($MediaId);

        $tpl = '<xml>
                <ToUserName><![CDATA[' . $this->_User_Id . ']]></ToUserName>
                <FromUserName><![CDATA[' . $this->_Service_Id . ']]></FromUserName>
                <CreateTime>' . time() . '</CreateTime>
                <MsgType><![CDATA[voice]]></MsgType>
                <Voice>
                <MediaId><![CDATA[%s]]></MediaId>
                </Voice>
                </xml>';

        $feedback = sprintf($tpl, $MediaId);

        return $feedback;
    }

    /*
        回复视频消息
    */
    private function _getVideoTpl($para = [])
    {
        $check = __FUNCTION__ . 'Para';
        $this->$check($para);

        $MediaId = isset($para['MediaId']) ? $para['MediaId'] : '';
        $Title = isset($para['Title']) ? $para['Title'] : '';
        $Description = isset($para['Description']) ? $para['Description'] : '';

        $tpl = '<xml>
                <ToUserName><![CDATA[' . $this->_User_Id . ']]></ToUserName>
                <FromUserName><![CDATA[' . $this->_Service_Id . ']]></FromUserName>
                <CreateTime>' . time() . '</CreateTime>
                <MsgType><![CDATA[video]]></MsgType>
                <Video>
                <MediaId><![CDATA[%s]]></MediaId>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                </Video>
                </xml>';

        $feedback = sprintf($tpl, $MediaId, $Title, $Description);

        return $feedback;
    }

    /*
        回复音乐消息
    */
    private function _getMusicTpl($para = [])
    {
        $check = __FUNCTION__ . 'Para';
        $this->$check($para);

        $Title = isset($para['Title']) ? $para['Title'] : '';
        $Description = isset($para['Description']) ? $para['Description'] : '';
        $MusicUrl = isset($para['MusicUrl']) ? $para['MusicUrl'] : '';
        $HQMusicUrl = isset($para['HQMusicUrl']) ? $para['HQMusicUrl'] : '';
        $ThumbMediaId = isset($para['ThumbMediaId']) ? $para['ThumbMediaId'] : '';

        $tpl = '<xml>
                <ToUserName><![CDATA[' . $this->_User_Id . ']]></ToUserName>
                <FromUserName><![CDATA[' . $this->_Service_Id . ']]></FromUserName>
                <CreateTime>' . time() . '</CreateTime>
                <MsgType><![CDATA[music]]></MsgType>
                <Music>
                <Title><![CDATA[%s]]></Title>
                <Description><![CDATA[%s]]></Description>
                <MusicUrl><![CDATA[%s]]></MusicUrl>
                <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
                </Music>
                </xml>';

        $feedback = sprintf($tpl, $Title, $Description, $MusicUrl, $HQMusicUrl, $ThumbMediaId);

        return $feedback;
    }

    /*
        回复图文消息
    */
    private function _getNewsTpl($para = [])
    {
        $check = __FUNCTION__ . 'Para';
        $this->$check($para);

        $num = count($para);
        $items = [];

        $tpl['main'] = '<xml>
                        <ToUserName><![CDATA[' . $this->_User_Id . ']]></ToUserName>
                        <FromUserName><![CDATA[' . $this->_Service_Id . ']]></FromUserName>
                        <CreateTime>' . time() . '</CreateTime>
                        <MsgType><![CDATA[news]]></MsgType>
                        <ArticleCount>%s</ArticleCount>
                        <Articles>
                        %s
                        </Articles>
                        </xml>';
        $tpl['item'] = '<item>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        <PicUrl><![CDATA[%s]]></PicUrl>
                        <Url><![CDATA[%s]]></Url>
                        </item>';

        foreach ($para as $v)
        {
            $Title = isset($v['Title']) ? $v['Title'] : '';
            $Description = isset($v['Description']) ? $v['Description'] : '';
            $PicUrl = isset($v['PicUrl']) ? $v['PicUrl'] : '';
            $Url = isset($v['Url']) ? $v['Url'] : '';

            $items[] = sprintf($tpl['item'], $Title, $Description, $PicUrl, $Url);
        }
        $separator = '';
        $item = implode($separator, $items);

        $feedback = sprintf($tpl['main'], $num, $item);

        return $feedback;
    }
}

?>