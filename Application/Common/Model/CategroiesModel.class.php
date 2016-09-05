<?php

namespace Common\Model;
use Think\Model;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/14
 * Time: 7:13
 */
class CategroiesModel extends Model {
    
    protected $categroies = null;
    public function getCategroies(){
        if(is_null($this->categroies)){
            
            $this->categroies = [];
            
            $cates = $this->select();
            foreach ($cates as $cate){
               
                if($cate['pid']==0){
                    $this->categroies[$cate['id']] = $cate;
                }
            }
           
            foreach ($cates as $cate){
                if($cate['pid']!=0){
                    $this->categroies[$cate['pid']]['child'][$cate['id']] = $cate;
                }
            }
        }
        return $this->categroies;
    }
    /**
     * 通过cid获取当前分类的名称
     */
    public function getCateName($cid){
        return $this->where(['id'=>$cid])->find();
    }
    /**
     * 通过父级id获取所有子id
     */
    public function getChildCate($parentID){
        return $this->where(['pid'=>$parentID])->select();
    }
    
    /**
     * 获取所有的分类
     */
    public function getAllCategroy(){
        $allCate = $this->select();
        //新建一个多维数组来保存分类及他们之间的关系
        $newArr = array();
        //一级分类
        foreach($allCate as $val){
            if($val['pid'] ==0){
                $newArr[$val['id']] = $val;//新建一个数组来存放一级目录的值
            }
        }
        //二级分类
        foreach($allCate as $val){
            if($val['pid'] !=0){
                $newArr[$val['pid']]['child'][$val['id']] = $val;
            }
        }
        return $newArr;
    }
    
    public function isParentCate($cid){
        $categroies = $this->getCategroies();
        
        return array_key_exists($cid, $categroies);
    }
    public function getChildCateVideoCount($childCateId){
        $videos = D('videos');
        $categroyVideo = M('categroies_videos');
        return $categroyVideo->alias('cv')
                ->join('left join __VIDEOS__ as v on v.id=cv.vid')
                ->where(['cv.cid'=>$childCateId])
                ->count();
       
    }
    public function getParentCateVideoCount($parentCateId){
        $videos = D('videos');
        $categroyVideo = M('categroies_videos');
        $categroy = $this->getCategroies();
        
        //取出每个一级分类下面的所有子分类id  再连表查询
        $childCateIds = [];
       
        foreach ($categroy[$parentCateId]['child'] as $childCate){
            $childCateIds[] = $childCate['id'];
        }
        
        $count = $categroyVideo->field('count(DISTINCT v.id) as c')->alias('cv')
                    ->join('left join __VIDEOS__ as v on v.id=cv.vid')
                    ->where(['cv.cid'=>['in',$childCateIds]])
                ->find();
        return $count['c'];
    }
    /**
     * Home
     * 获取每个一级分类下面的所有视频  并且按喜欢的个数选4个作为一级目录下面的推荐课程
     * 多对多关系 
     * 开发难点
     * SELECT * FROM `categroies_videos` cv left join videos v on v.id=cv.vid where cid in(10,11)  group by cv.vid order by v.likescount desc,v.ctime desc limit 3
     * @param 
     * @param array $orderBy  
     * @param type $limit  
     * @return type
     * 
     */
    public function getRecomVideos($parentCateId=0,$orderBy=[],$offset=0,$limit=0){
        $videos = D('videos');
        $categroyVideo = M('categroies_videos');
        
        
        $categroy = $this->getCategroies();
       
        if($parentCateId){
            $firstCategroy = [$parentCateId];
        }else{
            $firstCategroy = array_keys($categroy);
        }
        //取出每个一级分类下面的所有子分类id  再连表查询
        $arr = [];
        foreach($firstCategroy as $item){
            foreach ($categroy[$item]['child'] as $childCate){
                $arr[$item][] = $childCate['id'];
            }
        }
       
        //对传进来的排序参数处理
        if(!count(array_diff($orderBy,['likescount','ctime']))){
            //默认最新排序
            $orderBy = 'v.likescount DESC , v.ctime DESC';
        }else{
            $orderBy = array_map(function ($item){
                return 'v.'.$item.' DESC';
            },$orderBy);
            $orderBy = implode(',', $orderBy);
        }
        //按排序参数查询数据
        foreach($arr as $key => $val){
            $categroyVideo->field('DISTINCT v.*')->alias('cv')
                    ->join('left join __VIDEOS__ as v on v.id=cv.vid')
                    ->order($orderBy)
                    ->where(['cv.cid'=>['in',$val]]);
            if($limit!=0){
                $categroyVideo->limit($offset,$limit);
            }
            $res[$key] =  $categroyVideo->select(); 
            
        }
        if($parentCateId){
            return $res[$parentCateId];
        }
        return $res;
    }
     /**
     * 通过vid获取他的父级分类
     */
    public function getParentCategroy($vid){
        $cateVideos = M('categroies_videos');
        $cate = $cateVideos->where(['vid'=>$vid])
                ->find();
        $parentCate = $this->where(['id'=>$cate['cid']])
                ->find();
        return $parentCate;
    }
    /**
     * 获取一级分类
     */
    public function getFirstCategroy(){
        return $this->where(['pid'=>0])
                ->select();
    }
    /**
     * 获取所有的二级分类
     */
    public function getAllSubClass(){
        $data['pid'] = array('neq',0);
        return $this->where($data)
                ->select();
    }
    /**
     * 将视频和分类通过中间表建立关联
     */
   public function addCate($cid,$newVid){
        $cate_video = M('categroies_videos');
        $data['vid'] = $newVid;
        $data['cid'] = $cid;
        return $cate_video->add($data);
    }
}
