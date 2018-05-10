<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/4
 * Time: 18:42
 */

namespace Common\Model;

use Think\Model;

class PassportModel
{
    protected $tableName = 'users';
    protected $error = null;        // 错误信息
    protected $success = null;        // 成功信息

    /**
     * 返回最后的错误信息
     * @return string 最后的错误信息
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 返回最后的错误信息
     * @return string 最后的错误信息
     */
    public function getSuccess()
    {
        return $this->success;
    }

    /**
     * 验证用户是否已登录
     * 按照session -> cookie的顺序检查是否登陆
     * @return boolean 登陆成功是返回true, 否则返回false
     */
    public function isLogged()
    {
        if (isset($_SESSION['username'])) {
            //有session
            return true;
        } else if ($iden = $this->getCookieIden()) {
            //有cookie
            return $this->_recordLogin($iden);
        } else {
            //没有登录
            return false;
        }
    }

    /**
     * 获取cookie中记录的用户唯一识别码
     * @return integer cookie中记录的用户唯一识别码
     */
    public function getCookieIden()
    {
        //将cookie里面的iden提取出来用静态变量存储可避免多次从客户机中读取cookie
        static $cookie_iden = null;
        if ($cookie_iden !== null) {
            return $cookie_iden;
        }
        $cookie_iden = cookie('iden');
        if ($cookie_iden = $this->checkCookieIden($cookie_iden)) {
            return $cookie_iden;
        }
        return false;
    }

    /**
     * 验证cookie中的唯一标志码
     * @return bool
     */
    private function checkCookieIden($iden)
    {
        $userInfo = D('Users')->hasUser(['iden' => $iden]);
        return $userInfo;
    }

    /**
     * 设置登录状态、记录登录知识
     * @param integer $uid 用户ID
     * @param boolean $is_remember_me 是否记录登录状态，默认为false
     * @return boolean 操作是否成功
     */
    private function _recordLogin($iden, $is_remember_me = false)
    {
        // 第一次登录要注册cookie信息
        if (!$this->getCookieIden() && $is_remember_me) {
            $expire = 3600 * 24 * 7;//默认记住7天
            cookie(
                'iden', $iden['iden'],
                ['expire' => $expire, 'httponly' => false]
            );
        }
        // 注册session
        $_SESSION['username'] = $iden['username'];
        $_SESSION['uid'] = $iden['id'];
        $this->success = '登录成功啦(^.^)';
        return true;
    }

    /**
     * 登陆
     * @param string $uName 用户名
     * @param string $pass 密码
     * @param boolean $is_remember_me 是否记录登录状态，默认为false
     * @return boolean 是否登录成功
     */
    public function login($uName, $pass, $is_remember_me = false)
    {
        if (empty($uName) || empty($pass)) {
            $this->error = '帐号或密码不能为空(¬_¬)';
            return false;
        }
        //判断有咩有该用户
        $hasUserInfo = D('Users')->hasUser(['username' => $uName]);
        if (!$hasUserInfo) {
            $this->error = '帐号不存在(¬_¬)';
            return false;
        }
        //判断密码
        if ($pass == $hasUserInfo['password']) {
            //登录时向数据库写入一个唯一的iden
            $iden = md5($hasUserInfo['usernmae'] . uniqid());
            D('Users')->saveIden(['id' => $hasUserInfo['id']], $iden);
            $hasUserInfo['iden'] = $iden;
            $this->success = '登录成功啦^_^#';
            //写入session cookie
            return $this->_recordLogin($hasUserInfo, $is_remember_me);
        }
        $this->error = '密码错误o(︶︿︶)o';
        return false;
    }

    /**
     * 注销登录
     * @return void
     */
    public function logout()
    {
        //清除登录标志码
        D('Users')->delIden($_SESSION['username']);
        unset($_SESSION['username']); // 注销session
        cookie('iden', NULL);    // 注销cookie
    }

////////////////////////////////////

    /**
     * 添加账户
     */
    public function addUser($data)
    {

        if (D('Users')->hasUser(['username' => $data['username']])) {
            $this->error = '账号已存在^_^#';
            return false;
        }
        if (D('Users')->addUser($data)) {
            $this->success = '添加账号成功♪(´ε｀)';
            return true;
        } else {
            $this->error = '添加账号失败(ｰｰ;)';
            return false;
        }
    }
}