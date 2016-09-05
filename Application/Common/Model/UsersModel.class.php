<?php

/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/14
 * Time: 7:13
 */
namespace Common\Model;
use Think\Model;


class UsersModel extends Model
{
    /**
     * 判断有没有账户
     * @param array
     */
    public function hasUser($data){
        return $this->where($data)->find();
    }
    /**
     * 添加账户
     */
    public function addUser($data){
        return $this->add($data);
    }
    /**
     * 写入iden
     */
    public function saveIden($where,$iden){
        return $this->where($where)
            ->save(['iden'=>$iden]);
    }
    /**
     * 退出登录
     */
    public function delIden($username){
        $data['iden'] = '';
        return $this->where(['username'=>$username])
            ->save($data);
    }
}