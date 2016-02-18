<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 工具集合
 *
 * Last Modified Time: 2016-02-06 01:36:22
 */

namespace ericxie\wechat\traits;

trait Utils
{
    protected function getMsgContents()
    {
        $feedback = isset($GLOBALS["HTTP_RAW_POST_DATA"]) ? $GLOBALS["HTTP_RAW_POST_DATA"] : '';
        return $feedback != '' ? $feedback : file_get_contents('php://input');
    }

    protected function xmlToObj($data)
    {
        return simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);
    }

    protected function requestUrl($url, $para = '')
    {
        return file_get_contents($url);
    }

    protected function jsonDecode($json)
    {
        return json_decode($json);
    }
}

?>