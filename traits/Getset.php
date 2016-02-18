<?php
/**
 * Wechat --- Mr Xie's Wechat class for Yii2.
 *
 * 作者: EricXie | 邮箱: Mr.EricXie@gmail.com | 网站: http://www.ericxie.com
 *
 * 说明: 变量Get & Set
 *
 * Last Modified Time: 2016-02-01 10:51:32
 */

namespace ericxie\wechat\traits;

trait Getset
{
    public function setServerId($server_id)
    {
        $this->_Service_Id = $server_id;
    }

    public function setUserId($user_id)
    {
        $this->_User_Id = $user_id;
    }

    private function _setData($data = [])
    {
        $this->_setInfo(true,WECHATMSG_READ_SUCCESS,'',$data);
        $this->_Service_Id = isset($data['ToUserName']) ? $data['ToUserName'] : '';
        $this->_User_Id = isset($data['FromUserName']) ? $data['FromUserName'] : '';
    }

    private function _setError($errorCode = 0)
    {
        $this->_setInfo(false,$errorCode);
    }

    private function _setInfo($status = false, $errorCode = 0, $errorMsg = '', $data = [])
    {
        $this->_status = $status;
        $this->_errorCode = $errorCode;
        $this->_errorMsg = $errorMsg ? $errorMsg : $this->_getErrorMsg($errorCode);
        $this->_data = $data;
    }
}

?>