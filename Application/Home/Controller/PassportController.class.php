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
    public function regisger(){

        $this->display('User/signup');
    }

    public function doReg(){

       if(empty(I('post.name','','trim')) || empty(I('post.pwd','','trim')) || empty(I('post.rePwd','','trim'))){
           $this->error('用户名或密码不能为空(つд⊂)',U('Passport/regisger'));
       }
        $data['username'] = safetyHtml(I('post.name','','trim'));
        $data['password'] = md5(safetyHtml(I('post.pwd','','trim')));
        $rePwd = md5(safetyHtml(I('post.rePwd','','trim')));
        //判断两次密码一致性
        if($data['password'] != $rePwd){
            $this->error('两次密码不一致.');
        }
        $data['ctime'] = time();
        $passport = D('Passport');
        //添加用户
        if( $passport->addUser($data) ){
            $this->success($passport->getSuccess(),U('Passport/index'));
        }else{
            $this->error($passport->getError());
        }
    }
}