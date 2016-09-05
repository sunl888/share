<?php

namespace Home\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/22
 * Time: 7:13
 */
class SearchController extends BaseController{
    public function index(){
        $videos = D('Videos');
        $cate = D('Categroies');
        $limit = C('SEARCH.LIST_LIMIT',NULL,9);
        $keyword = I('get.keyword','','trim');

        $page = new \Think\Page($videos->countFindVideosByString($keyword),$limit);
        $find = $videos->findVideosByString($keyword , $page->firstRow , $page->listRows);
        $childCate = $cate->getAllSubClass();

        $this->assign('childCate',$childCate);
        $this->assign('keyword',$keyword);
        $this->assign('page',$page);
        $this->assign('find',$find);
        $this->display();
    }
    /**
     * 搜索
     */
    public function search(){
        
        header("Access-Control-Allow-Origin:*");
        
        $name = I('get.name',null);
        if(empty($name)){
            die();
        }
        $this->assign('keyWords',$name);
        $videos = D('Videos');
        $searchResult = $videos->findVideosByString($name);
        
        $this->assign('searchResult',$searchResult);
        $this->display('searchResult');
    }
}