<?php

namespace Home\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/21
 * Time: 9:48
 */
class DetailController extends BaseController{
    
    public function index(){
        $video = D("Videos");
        $cate = D("Categroies");
        $vid = I("get.vid","","trim");
        //$vid = 2;
        //获取视频介绍
        $videoInfo = $video->getVideosByVid($vid);
//p($videoInfo);
        //子视频列表
        $videoItem = $video->getVideosItemByVid($vid);
      
	 //猜你喜欢
        $relaVideo = $video->getRelatedVideoByVid($vid,0,4); 
        //面包屑导航
        $parentCate = $cate->getParentCategroy($vid);
        $this->assign('parentCate',$parentCate);
        $this->assign('videoInfo',$videoInfo);
        $this->assign('videoItem',$videoItem);
        $this->assign('relaVideos',$relaVideo);
        $this->display();
    }
}
