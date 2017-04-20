<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/8/3
 * Time: 12:41
 */

namespace Common\Model;
use Think\Model;

class ViewModel extends Model
{
    //指定表名
    protected $tableName = 'views';
    //获取浏览者信息
    public function addViewerInfo(){

        $data['user_name'] = empty($_SESSION['username']) ? '保密' : $_SESSION['username'];
        $data['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
        //$data['user_ip'] = $_SERVER['SERVER_ADDR'];
        $data['user_ip'] = get_client_ip();
        $data['vtime'] = time();
        $this->add($data);
    }
    public function webWiews(){
        return $this->count();
    }
}