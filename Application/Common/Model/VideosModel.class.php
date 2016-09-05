<?php
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/14
 * Time: 7:13
 */
namespace Common\Model;
use Think\Model;

class VideosModel extends Model{

    /**
     * 获取某个分类的所有视频  
     * @param type $cid 类别id
     * @param type $limit 列表个数
     * @param type $offset 偏移量
     * @return type
     */
    public function getVideosListByCateId($orderBy , $cid  , $offset = 0 , $limit){
        
        //对传进来的排序参数处理
        if(!count(array_diff($orderBy,['likescount','ctime']))){
            //默认最新排序
            $orderBy = 'likescount DESC , ctime DESC';
        }else{
            $orderBy = array_map(function ($item){
                return $item.' DESC';
            },$orderBy);
            $orderBy = implode(',', $orderBy);
        }
        
        return $this->where(['c.cid'=>intval($cid),'v.deleted_by'=>0])
                ->alias('v')
                ->join('right join __CATEGROIES_VIDEOS__ as c on c.vid = v.id')
                ->order($orderBy)
                ->limit($offset , $limit)
                ->select();//获取相关视频的id
    }
    
    /**
     * 最新的视频
     */
    public function getNewVideos($offset=0,$limit){
        $videos = $this->order('ctime desc')->limit($offset,$limit)->select();
       
        return $videos;
    }
    /**
     * 最热的视频
     */
    public function getHotVideos($offset=0,$limit){
        $videos = $this->order('likescount desc,ctime desc')->limit($offset,$limit)->select();
        
        return $videos;
    }
    
    /**
     *通过vid获取视频的所有子视频 
     */
    public function getVideosItemByVid($vid=1,$offset=0,$limit){
         $videosItem =  $this->alias('v')
                            ->join('right join __VIDEOS_ITEM__ as vItem on vItem.vid = v.id')
                            ->where(['v.id'=>intval($vid),'v.deleted_by'=>0])
                            ->limit($offset,$limit)
                            ->select();
         return $videosItem;
    }
    
    /**
     * 通过vid获取视频的介绍等信息
     */
    public function getVideosByVid($vid){
        
        $videosInfo = $this->alias('v')
                ->field('v.*,u.username as vRes')
                ->where(['v.id'=>$vid])
                ->join("right join __USERS__ as u on v.uid = u.id")
                ->find();
        
        return $videosInfo;
    }
    
    /**
     * 通过vid获取相关的vid视频  
     * 只获取3个相关视频
     */
    public function getRelatedVideoByVid($vid,$offset=0,$limit=3){
        $cateVideos = M('categroies_videos');
        $getCid = $cateVideos->where(['vid'=>$vid])
                ->find();
        //p($getCid);  vid=1  cid=10
        $getRelatedVideos = $this->alias('v')
                ->join('right join __CATEGROIES_VIDEOS__ as c on c.vid = v.id')
                ->order('likescount desc,ctime desc')
                ->where(['c.cid'=>$getCid['cid']])
                ->limit($offset,$limit)
                ->select();
        //p($getRelatedVideos);
        return $getRelatedVideos;
    }
    
    /**
     * 通过视频的名称模糊查询
     */
    public function findVideosByString($name ,$offset=0,$limit){
        return $this->where(['name'=>array('like',"%$name%")])
                ->limit($offset,$limit)
                ->select();
    }
    public function countFindVideosByString($name){
        return $this->where(['name'=>array('like',"%$name%")])
                ->count();
    }
    /**
     * 喜欢某个视频
     * 
     */
    public function likeVideos($uid,$vid){
         //视频喜欢量加1
        $arr = $this->where(['id'=>$vid])
                ->find();
        $data['likescount']=$arr['likescount']+1;
        $this->where(['id'=>$vid])
                ->save($data);
        //在likes表中添加一条数据 
        $likes = M('likes');
        $data['uid'] = $uid;
        $data['vid'] = $vid;
        $likes->add($data);
    }
    /**
     * 取消喜欢某个视频
     * 
     */
    public function unLikeVideos($uid,$vid){
        //视频喜欢量减1
       $arr = $this->where(['id'=>$vid])
                ->find();
        $data['likescount']=$arr['likescount']-1;
        $this->where(['id'=>$vid])
                ->save($data);
        
        $likes = M('likes');
        $likes->where(['uid'=>$uid,'vid'=>$vid])
              ->delete();
    }
    /**
     * 判断有没有喜欢该视频
     */
    public function isLikeVideos($uid,$vid){
        $likes = M('likes');
        return $likes->where(['uid'=>$uid,'vid'=>$vid])
                ->find(); 
    }
    public function getAllVideo($orderBy , $offset=0 , $limit){
        
        //对传进来的排序参数处理
        if(!count(array_diff($orderBy,['likescount','ctime']))){
            //默认最新排序
            $orderBy = 'likescount DESC , ctime DESC';
        }else{
            $orderBy = array_map(function ($item){
                return $item.' DESC';
            },$orderBy);
            $orderBy = implode(',', $orderBy);
        }
        return $this->order($orderBy)->limit($offset,$limit)->select();
    }
    public function addVideo($videoName,$cover,$intro ,$uid){
        //ctime 自动生成
        $data['name'] = $videoName;
        $data['cover'] = $cover;
        $data['intro'] = $intro;
        $data['uid'] = $uid;
        $data['ctime'] = time();
        return $this->add($data);
    }
}
