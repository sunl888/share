<?php

namespace Mobile\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/16
 * Time: 13:12
 */
class PlayController extends BaseController{
    
    public function index(){
        $this->display();
    }
    
    /**
     * 通过vid获取视频的所有子视频
     */
    public function getVideosItem(){
        
        $vid = I("get.vid",0,"intval");
        $videos = D('Videos');
        //通过用户选择的视频id 从videosItem表中获取所有子视频.
        $videosItemInfo = $videos->getVideosItemByVid($vid);
        foreach($videosItemInfo as $val){
            $childVideo[$val['id']] = $val;
        }
        //子视频的id  控制播放器从哪个子视频开始播放
        $vItemid = I("get.vitemid",0,"intval");
        //当vItemid等于0说明没有传过来  默认播放第一个子视频
        if(!$vItemid){
            $vItemid = $videosItemInfo[0]['id'];
        }
        //判断有没有登录,如果登录了判断他有没有喜欢过该视频
        $sessionAll = session();
        if($sessionAll != null){
            $like = $videos->isLikeVideos($sessionAll['uid'],$vid);
            if($like){
                $this->assign('isLike',1);
            }else{
                $this->assign('isLike',0);
            }
        }else{
           $this->assign('isLike',0); 
        }
        
        
         //视频的信息
        $videosInfo = $videos->getVideosByVid($vid);
        
        //获取相关推荐视频
        $getRelaVideos = $videos->getRelatedVideoByVid($vid);
        $this->assign('vItemid',$vItemid);
        $this->assign('cid',$getRelaVideos[0]['cid']);
        $this->assign('getRelaVideos',$getRelaVideos);
        $this->assign('videosItemInfo',$childVideo);
        $this->assign('videosInfo',$videosInfo);
        $this->display('index');
    }
    
    /**
     * 喜欢/取消喜欢该视频
     * $option=1表示我要喜欢该视频
     */
    public function likeVideo(){
        if(IS_AJAX){
            //判断用户有没有登录
            $option = I('get.option',0,'intval');
            $vid = I('get.vid',0,'intval');
            $sessionAll = session();
            $videos = D('Videos');
            //如果用户登录过
            if($sessionAll['username']){
                if($option == 1){
                    $videos->likeVideos($sessionAll['uid'],$vid);
                }else{
                    $videos->unLikeVideos($sessionAll['uid'],$vid);
                }
            }else{
                //用户没有登录
                //给视图返回一个标识,当用户登录后才把喜欢的图标改变  否则不改变
                echo json_encode(['status'=>-1,'message'=>'笨啊,不登陆你喜欢毛线啊.快滚去登录']);
            }
        }
    }
}
