<?php

namespace Mobile\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/14
 * Time: 7:13
 */

class IndexController extends BaseController {
    public function index(){
        $users = D('Users');
        $videos = D('Videos');
        $videosItem = D('VideosItem');
        $categroies = D('Categroies');
        
        //获取最新视频
        $newVideos = $videos->getNewVideos(0,3);
        //获取最热视频
        $hotVideos = $videos->getHotVideos(0,3);
        //热门搜索
        $hotSearch = $videos->getHotVideos(0,8);
        //获取所有视频分类
        $categroy = $categroies->getAllCategroy();

        //获取浏览者信息
        D('View')->addViewerInfo();

        $this->assign('newVideos',$newVideos);
        $this->assign('hotVideos',$hotVideos);
        $this->assign('hotSearch',$hotSearch);
        $this->assign('categroy',$categroy);
        $this->display();
    }
    /**
     * 搜索
     */
    public function search(){
        
        header("Access-Control-Allow-Origin:*");
        layout(FALSE);
        $name = I('get.name',null);
        if(empty($name)){
            die();
        }
        $this->assign('keyWords',$name);
        $videos = D('Videos');
        $searchResult = $videos->findVideosByString($name);
        //p($searchResult);
        $this->assign('searchResult',$searchResult);
        $this->display('searchResult');
    }

}