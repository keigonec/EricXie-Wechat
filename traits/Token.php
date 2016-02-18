<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: Token集合
 *
 * Last Modified Time: 2016-02-15 00:04:55
 */

namespace ericxie\wechat\traits;

use Yii;

trait Token
{
    private function _getAccessToken($appid = '', $appsecret = '')
    {
        return $this->_getTokenFromCache($appid,$appsecret);
    }

    private function _getTokenFromCache($appid, $appsecret)
    {
        $token = false;

        switch ($this->_Token_Cache)
        {
            case 'file':
                $tokenfile = $this->_Token_Key . '.php';

                if(file_exists($tokenfile))
                {
                    include($tokenfile);
                    if(isset($token_file))
                    {
                        $token_obj = $this->jsonDecode($token_file);
                        if((isset($token_obj->expire)) && (time() < $token_obj->expire))
                        {
                            $token = isset($token_obj->token) ? $token_obj->token : false;
                        }
                    }
                }
                break;

            case 'memcache':
                $tmp = Yii::$app->memcache->get($this->_Token_Key);
                $token = is_string($tmp) ? $tmp : false;
                break;

            case 'redis':
                $tmp = Yii::$app->redis->get($this->_Token_Key);
                $token = is_string($tmp) ? $tmp : false;
                break;
        }

        if($token)
        {
            return $token;
        }
        else
        {
            return $this->_getTokenFromWechat($appid, $appsecret);
        }
    }

    private function _getTokenFromWechat($appid, $appsecret)
    {
        $target = sprintf(URL_ACCESSTOKEN, $appid, $appsecret);
        $token_obj = $this->jsonDecode($this->requestUrl($target));

        if(isset($token_obj->access_token))
        {
            $token_life = $token_obj->expires_in + time() - TOKEN_LIFE_RESERVE;

            switch ($this->_Token_Cache)
            {
                case 'file':
                    $output = "<?php \$token_file = '";
                    $output .= json_encode(array('token' => $token_obj->access_token, 'expire' => $token_life));
                    $output .= "';?>";

                    file_put_contents($this->_Token_Key . '.php', $output);
                    break;

                case 'memcache':
                    Yii::$app->memcache->set($this->_Token_Key, $token_obj->access_token, $token_life);
                    break;

                case 'redis':
                    Yii::$app->redis->set($this->_Token_Key, $token_obj->access_token);
                    Yii::$app->redis->expire($this->_Token_Key, $token_life);
                    break;
            }

            return $token_obj->access_token;
        }
        else
        {
            return false;
        }
    }
}