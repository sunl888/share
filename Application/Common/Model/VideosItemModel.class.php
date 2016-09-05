<?php

namespace Common\Model;
use Think\Model;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/14
 * Time: 7:13
 */
class VideosItemModel extends Model{
    
    /**
     * @param type $vid
     * 获取一个视频中的所有子视频
     */
    public function getVideosById($vid){
        
        $getvideos_item = $this->where(['vid' => $vid])
             ->select();
        return $getvideos_item;
    }
    /**
     * 上传视频
     */
    public function upload($name,$filePath,$videoTime,$vid,$videoSize){
        $data['name'] = $name;
        $data['addr'] = $filePath;
	$data['timelength'] = $videoTime;
        $data['vid'] = $vid;
        $data['size'] = $videoSize;
        return $this->add($data);
    }
    /**
     * 通过子id获取子视频信息
     * 下载视频
     */
    public function getVideoItemByID($vitemID){
        return $this->where(['id'=>$vitemID])
            ->find();
    }
}
