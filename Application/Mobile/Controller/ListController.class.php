<?php

namespace Mobile\Controller;

/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/15
 * Time: 9:15
 */
class ListController extends BaseController{

    public function index(){
        $this->display();
    }
    /**
     * 查看更多热门视频或最新视频
     */
    public function findMore(){
        //flag=0表示热门视频  flag=1表示最新视频
        $flag = I('get.flag',0,'intval');
        if($flag == 1){
            $videosCateName = "最新视频";
        }else{
            $videosCateName = "热门视频";
        }
        
        if(IS_AJAX){
            //关闭页面布局
            layout(false);
            //如果是ajax请求则获取每次动态加载的视频个数
            $limit =I('get.limit',0,'intval');
            $offset =I('get.offset',0,'intval');
            //ajax请求返回list内容
            $videos = D('Videos');
            //查看所有最新视频
            if($flag == 1){
                $videosList = $videos->getNewVideos($offset,$limit);
            }else{
                //查看所有最热视频
               $videosList = $videos->getHotVideos($offset,$limit); 
            }
            $this->assign('videosList',$videosList);
            $this->display('listItem');
        }else{
            //不是ajax请求的时候输出页面

            //把当前类别名称传给视图
            $this->assign('videosCateName',$videosCateName);
            
            $this->assign('flag',$flag);;
            $this->assign('listUrl',U('findMore',['flag'=>$flag]));
            $this->display("index");
        } 
    }
    /**
     * 显示当前类别内容列表
     */
    public function categroyVideos(){
        
        //获取当前类别id
        $cid = I('get.cid',0,'intval');
                
        if(IS_AJAX){
            //关闭页面布局
            layout(false);
            
            //如果是ajax请求则获取每次动态加载的视频个数
            $limit =I('get.limit',0,'intval');
            $offset =I('get.offset',0,'intval');
            
            //ajax请求返回list内容
            $videos = D('Videos');
            //获取当前分类的所有视频
            $videosList = $videos->getVideosListByCateId([] , $cid,$offset,$limit);
            $this->assign('videosList',$videosList);
            $this->display('listItem');
        }else{
            
            //不是ajax请求 返回视图
            $categroy = D('Categroies');
            
            //获取当前分类的名称  用来显示在导航栏
            $videosCateName = $categroy->getCateName($cid);
            $videosCateName = $videosCateName['name'];
            $this->assign('videosCateName',$videosCateName);
            
            //把当前分类id传给视图 让ajax获取cid之后动态查询加载数据
            $this->assign('listUrl',U('categroyVideos',['cid'=>$cid]));
            $this->display("index");
        }
    }
    /**
     * 获取全部视频
     */
    public function getAllVideos(){
        
        if(IS_AJAX){
            //关闭页面布局
            layout(false);
            
            //如果是ajax请求则获取每次动态加载的视频个数
            $limit =I('get.limit',0,'intval');
            $offset =I('get.offset',0,'intval');
            //ajax请求返回list内容
            $videos = D('Videos');
           
            //获取当前分类的所有视频
            $videosList = $videos->getHotVideos($offset,$limit);
            $this->assign('videosList',$videosList);
            $this->display('listItem');
        }else{
            
            //获取当前分类的名称  用来显示在导航栏
            $videosCateName = '全部课程';
            $this->assign('videosCateName',$videosCateName);
            $this->assign('listUrl',U('getAllVideos'));
            $this->display("index");
        }
    }
}