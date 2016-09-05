<?php

namespace Home\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/20
 * Time: 18:45
 */
class ClassifyController extends BaseController{
    
    
    public function index(){
        $cate = D('Categroies');
        $videos = D('Videos');
        //flag=0表示最新
        $sort = I('get.sort','new','trim');
        if(!in_array($sort, ['new','hot'])){
            $sort = 'new';
        }
        if($sort == 'hot'){
            $order_by = ['likescount','ctime'];
        }else{
            $order_by = ['ctime','likescount'];
        }
        $cid = I("get.cid",0,"intval");
        $limit = C('CLASSIFY.LIST_LIMIT',NULL,16);
        $page = null;
        //所有分类
        $allCates = $cate->getCategroies();
        //如果没有传cid则输出所有列表以及视频
        //$offset = 0;
        //$limit = 3;
        $childCate = [];
        if($cid == 0){
            foreach($allCates as $parentCate){
                foreach ($parentCate['child'] as $child){
                    $childCate[$child['id']] = $child;
                }
            }
            $parentCateId=0;
            $childCateId=0;
            
            $page = new \Think\Page($videos->count(),$limit);
            $videosList = $videos->getAllVideo($order_by , $page->firstRow , $page->listRows);
        }else if($cate->isParentCate($cid)){
            //获取一级列表的所有子列表
            $childCate = $cate->getChildCate($cid);
            $page = new \Think\Page($cate->getParentCateVideoCount($cid),$limit);
            $videosList = $cate->getRecomVideos($cid,$order_by,$page->firstRow,$page->listRows);
            $parentCateId=$cid;
            $childCateId=0;
        }else{
            $currentCate = $cate->find($cid);
            if(is_null($currentCate)){
                //TODO 404
                die('404');
            }
            $childCate = $allCates[$currentCate['pid']]['child'];
            $page = new \Think\Page($cate->getChildCateVideoCount($cid),$limit);
            
            $videosList = $videos->getVideosListByCateId($order_by , $cid,$page->firstRow,$page->listRows);
            $parentCateId=$currentCate['pid'];
            $childCateId=$cid;
        }
        $page->setConfig('first','首页');
        $page->lastSuffix = FALSE;
        $page->setConfig('last','末页');
        $page->setConfig('prev','上一页');
        $page->setConfig('next','下一页');
        $this->assign('page',$page);
        $this->assign('cid',$cid);
        $this->assign('sort',$sort);
        $this->assign('parentCateId',$parentCateId);
        $this->assign('childCateId',$childCateId);
        $this->assign('childCate',$childCate);
        $this->assign('videosList',$videosList);
        $this->assign('allCate',$allCates);
        $this->display();
    }
}
