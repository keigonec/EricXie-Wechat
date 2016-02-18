<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 各种检查
 *
 * Last Modified Time: 2016-02-15 10:29:19
 */

namespace ericxie\wechat\traits;

use Yii;
use ericxie\wechat\exceptions\RuntimeException;

trait Check
{
    private function _selfcheck()
    {
        switch ($this->_Token_Cache)
        {
            case 'file':
                $this->_checkFileIsWritable();
                break;

            case 'memcache':
                $this->_checkMemcache();
                break;

            case 'redis':
                $this->_checkRedis();
                break;
        }
    }

    private function _checkFileIsWritable()
    {
        $tokenfile = $this->_Token_Key . '.php';

        //检查token缓存文件是否存在
        if(file_exists($tokenfile))
        {
            //文件已存在，检查是否可写
            if(!is_writable($tokenfile))
            {
                throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_FILE_UNWRTIABLE));
            }
        }
        else
        {
            //尝试写文件来确定目录是否可写
            if(file_put_contents($tokenfile, '<?php?>') === false)
            {
                throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_FILE_UNWRTIABLE));
            }
        }
    }

    private function _checkMemcache()
    {
        //检查memcache配置
        if(!isset(Yii::$app->components['memcache']))
        {
            throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_NO_MEMCACHE));
        }

        //检查memcache配置是否是yii自带memcache
        if(Yii::$app->components['memcache']['class'] != 'yii\caching\MemCache')
        {
            throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_INVALID_MEMCACHE_CLASS));
        }

        //检查memcache服务连接状况
        $servers = Yii::$app->memcache->getServers();
        $memcache = false;
        foreach ($servers as $v)
        {
            $readay = @memcache_connect($v->host, $v->port);
            if($readay)
            {
                $memcache = true;
                break;
            }
        }

        if(!$memcache)
        {
            throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_MEMCACHE_UNABLE_CONNECT));
        }
    }

    private function _checkRedis()
    {
        //检查Redis配置
        if(!isset(Yii::$app->components['redis']))
        {
            throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_NO_REDIS));
        }

        //检查使用的Redis是否为yii2-redis
        $redis_folder = Yii::getAlias('@yii/redis');

        if(strpos($redis_folder, 'yiisoft/yii2-redis') !== false)
        {
            if(!file_exists($redis_folder . '/Connection.php'))
            {
                throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_INVALID_REDIS_CLASS));
            }
        }
        else
        {
            throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_INVALID_REDIS_CLASS));
        }

        //检查Redis服务连接状况
        $redis = @stream_socket_client(Yii::$app->redis->hostname . ':' . Yii::$app->redis->port, $errno, $errstr, 1);

        if(!$redis)
        {
            throw new RuntimeException($this->_getErrorMsg(WECHATMSG_INIT_REDIS_UNABLE_CONNECT));
        }
    }
}

?>