<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 安全相关
 *
 * Last Modified Time: 2016-02-15 00:04:40
 */

namespace ericxie\wechat\traits;

use Yii;

trait Security
{
    private function _getWechatServer($appid = '', $appsecret = '')
    {
        $token = $this->_getAccessToken($appid,$appsecret);
        $target = sprintf(URL_SERVERS, $token);
        $ip_array = $this->jsonDecode($this->requestUrl($target));

        if(isset($ip_array->ip_list))
        {
            return $ip_array->ip_list;
        }
        else
        {
            return false;
        }
    }
}