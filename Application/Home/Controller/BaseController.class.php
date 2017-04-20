<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/2
 * Time: 9:58
 */

namespace Home\Controller;
use Think\Controller;

class BaseController extends Controller
{
    /**
     * 控制器初始化
     * @return void
     */
    protected function _initialize(){
        $view = D('View');
        $webView = $view->webWiews();
        $this->assign('webView',$webView);
        $this->initUser();
    }
    private function initUser(){

        // 验证是否已经登陆
        /*if ( !( D('Passport')->isLogged() ) ) {

            $this->redirect('Passport/index');
        }*/
        //判断session > cookie 如果有则表示已经登录
        D('Passport')->isLogged();
        return true;
    }

    /**
     * 文件下载方法
     * download(文件名[路径] , 下载时显示的文件名)
     */
    public function down(){
        $vItem = safetyHtml(I('get.vItem','','trim'));
	 $item = D('VideosItem')->getVideoItemByID($vItem);
	//Linux上应该改为 / 可能与表中不符  所以需要替换成系统默认的.
	$item['addr'] = str_replace('\\' , DIRECTORY_SEPARATOR , $item['addr']);
        if(empty($item)){
            $this->error("文件下载失败");
        }
        //获取文件扩展名
        $ext = exte($item['addr']);
        \Org\Net\Http::download($item['addr'] , $item['name'].".$ext");
	
    }
}
