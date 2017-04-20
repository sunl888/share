<?php

namespace Home\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/24
 * Time: 7:13
 */
class PlayController extends BaseController{

    public function index(){
        $video = D("Videos");
        $cate = D("Categroies");

        //获取子视频的父级id  用来显示在视频播放页的列表中
        $vid = I("get.vid","","trim");

        //获取视频介绍
        $videoInfo = $video->getVideosByVid($vid);
        //子视频列表
        $videoItem = $video->getVideosItemByVid($vid);
        foreach($videoItem as $val){
            $childVideo[$val['id']] = $val;
        }
        //子视频的id  控制播放器从哪个子视频开始播放
        $vItemid = I("get.vItemid",0,"intval");

        //当vItemid等于0说明没有传过来  默认播放第一个子视频
        if(!$vItemid){
            $vItemid = $videoItem[0]['id'];
        }
        //猜你喜欢
        $relaVideo = $video->getRelatedVideoByVid($vid,0,4); 
        //面包屑导航
        $parentCate = $cate->getParentCategroy($vid);

        $this->assign('videoItemID',$vItemid);//控制视频播放器播放指定子视频
        $this->assign('parentCate',$parentCate);
        $this->assign('videoInfo',$videoInfo);
        $this->assign('videoItem',$childVideo);
        $this->assign('relaVideos',$relaVideo);
        $this->display();
    }
}
