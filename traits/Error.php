<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 错误编码和信息
 *
 * Last Modified Time: 2016-02-14 23:56:05
 */

namespace ericxie\wechat\traits;

define('WECHATMSG_INIT_FILE_UNWRTIABLE', 101);
define('WECHATMSG_INIT_NO_MEMCACHE', 102);
define('WECHATMSG_INIT_NO_REDIS', 103);
define('WECHATMSG_INIT_INVALID_MEMCACHE_CLASS', 104);
define('WECHATMSG_INIT_INVALID_REDIS_CLASS', 105);
define('WECHATMSG_INIT_MEMCACHE_UNABLE_CONNECT', 106);
define('WECHATMSG_INIT_REDIS_UNABLE_CONNECT', 107);

define('WECHATMSG_READ_SUCCESS', 201);
define('WECHATMSG_READ_MSG_EMPTY', 202);
define('WECHATMSG_READ_MSGTYPE_INVALID', 203);
define('WECHATMSG_READ_EVENTTYPE_INVALID', 204);

define('WECHATMSG_SEND_SUCCESS', 301);

trait Error
{
    private function _getErrorMsg($code)
    {
        $lang = in_array(strtolower($this->_lang), ['chs', 'en']) ? strtolower($this->_lang) : 'chs';

        $unknowError = ['chs' => '未知错误', 'en' => 'Unknow Error'];

        $msgArray = [
            WECHATMSG_INIT_FILE_UNWRTIABLE => ['chs' => '缓存文件不可写',
                                        'en' => 'File is unwritable'
                                        ],
            WECHATMSG_INIT_NO_MEMCACHE => ['chs' => '未找到Memcache配置',
                                        'en' => 'No memcache config find'
                                        ],
            WECHATMSG_INIT_NO_REDIS => ['chs' => '未找到Redis配置',
                                        'en' => 'No redis config find'
                                        ],
            WECHATMSG_INIT_INVALID_MEMCACHE_CLASS => ['chs' => 'Memcache类文件不是Yii原生类',
                                        'en' => 'Class file of memcache is not Yii class'
                                        ],
            WECHATMSG_INIT_INVALID_REDIS_CLASS => ['chs' => 'Redis类文件不是Yii2-redis类',
                                        'en' => 'Class file of redis is not Yii2-redis class'
                                        ],
            WECHATMSG_INIT_MEMCACHE_UNABLE_CONNECT => ['chs' => 'Memcache服务器连接失败',
                                        'en' => 'Failed to connect memecache server'
                                        ],
            WECHATMSG_INIT_REDIS_UNABLE_CONNECT => ['chs' => 'Redis服务器连接失败',
                                        'en' => 'Failed to connect redis server'
                                        ],
            WECHATMSG_READ_SUCCESS => ['chs' => '读取信息成功',
                                        'en' => 'Success to read msg'
                                        ],
            WECHATMSG_SEND_SUCCESS => ['chs' => '发送信息成功',
                                        'en' => 'Success to send msg'
                                        ],
            WECHATMSG_READ_MSG_EMPTY => ['chs' => '信息获取失败',
                                        'en' => 'Failed to read msg'
                                        ],
            WECHATMSG_READ_MSGTYPE_INVALID => ['chs' => '消息类型不合法',
                                        'en' => 'Msg type invalid'
                                        ],
            WECHATMSG_READ_EVENTTYPE_INVALID => ['chs' => '事件类型不合法',
                                        'en' => 'Event type invalid'
                                        ],
        ];

        return isset($msgArray[$code]) ? APP_NAME . ' : ' . $msgArray[$code][$lang] : APP_NAME . ' : ' . $unknowError['lang'];
    }
}

?>