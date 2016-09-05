<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/8/2
 * Time: 10:50
 */

namespace Mobile\Controller;
use Think\Controller;

class BaseController extends Controller
{
    /**
     * 控制器初始化
     * @return void
     */
    protected function _initialize(){
        $this->initUser();
    }
    private function initUser(){
        // 验证是否已经登陆
        //判断session > cookie 如果有则表示已经登录
        D('Passport')->isLogged();
        return true;
    }
}