<?php

namespace Home\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/20
 * Time: 7:13
 */
class IndexController extends BaseController {

    /**
     *
     */
    public function index(){

        $users = D('Users');
        $videos = D('Videos');
        $videosItem = D('VideosItem');
        $categroies = D('Categroies');
        
        //获取所有视频中最新的视频
        $newVideos = $videos->getNewVideos(0,4);
        //获取所有视频中最热de视频
        $hotVideos = $videos->getHotVideos(0,4);
        
        //获取所有视频分类
        $categroy = $categroies->getAllCategroy();
        //获取所有的一级分类
        $firstCategroy = $categroies->getFirstCategroy();
        //推荐视频 每个大分类下面有3个推荐视频  按likescount排序 likescount相同则按ctime排序  
        $firstRecomVideos = $categroies->getRecomVideos(0,['likescount','ctime'],0,3);
        //最新视频 每个大分类下面有4个最新视频  按ctime排序  相同则按likescount排序
        $firstNewVideos = $categroies->getRecomVideos(0,['ctime','likescount'],0,4);

        //获取浏览者信息
        D('View')->addViewerInfo();

        $this->assign('parentCategroys',$firstCategroy);
        $this->assign('newVideos',$newVideos);
        $this->assign('hotVideos',$hotVideos);
        $this->assign('firstRecomVideos',$firstRecomVideos);
        $this->assign('firstNewVideos',$firstNewVideos);
        $this->assign('categroy',$categroy);
        $this->display();
    }
}