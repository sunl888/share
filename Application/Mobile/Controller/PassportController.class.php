<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/4
 * Time: 18:44
 */

namespace Mobile\Controller;
use Think\Controller;

class PassportController extends Controller
{
    public function index(){
        //登录
        $this->display('User/login');
    }
    public function doLogin(){
        $name = I('post.username','','trim');
        $pwd = md5(I('post.password','','trim'));
        $is_remember_me = true;
        $passport = D('Passport');

        if( $passport->login($name , $pwd , $is_remember_me) ){
            $this->redirect('Index/index');
        }else{
            $this->error($passport->getError());
        }
    }
    
    /**
     * 退出登录
     */
    public function unLogin(){
        D('Passport')->logout();
        $this->success('退出账号成功(つд⊂)伤心' , U('Index/index'));
    }

}
