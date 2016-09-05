<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/4
 * Time: 18:44
 */

namespace Home\Controller;
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
        $is_remember_me = I('post.checkbox') ? true : false;
        $passport = D('Passport');

        if( $passport->login($name , $pwd , $is_remember_me) ){
            $this->success($passport->getSuccess(),U('Index/index'));
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


///////////////////////////////////////
    /**
     * 注册账号
     */
    public function reg(){

        $this->display('register');
    }
    public function doReg(){
        $data['username'] = safetyHtml(I('post.username','','trim'));
        $data['password'] = md5(safetyHtml(I('post.password','','trim')));
        $data['mobile'] = safetyHtml(I('post.mobile','','trim'));
        $data['ctime'] = time();

        $passport = D('Passport');

        if( $passport->addUser($data) ){
            $this->success($passport->getSuccess(),U('Passport/login'));
        }else{
            $this->error($passport->getError());
        }
    }
}