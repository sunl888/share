<?php


namespace Home\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/25
 * Time: 7:13
 */
class UploaderController extends BaseController
{

    /**
     * 上传视频的基本信息页面
     */
    public function index()
    {
        $videos = D('Videos');
        $categroies = D('Categroies');

        //判断有没有登录
        if (empty($_SESSION['username'])) {
            $this->redirect("Passport/index", "", 2, "亲,想上传视频请先登录喔");
        }
        //获取所有视频分类
        $categroy = $categroies->getAllCategroy();
        $this->assign('categroy', $categroy);
        $this->display();
    }

    /**
     * 提交要上传视频的基本信息
     */
    public function uploadVideoInfo()
    {

        $categroy = D('Categroies');
        $videos = D('Videos');

        $cate = array();
        $cate = $_POST['categroy'];
        if ($cate === null) {
            $this->redirect("Uploader/index", "", 2, "你还没有选择视频分类");
            die;
        }
        //过滤不安全的标签
        $videoName = I('post.videoName', '', 'safetyHtml');
        $videoIntro = I('post.videoIntro', '', 'safetyHtml');
        if (empty($videoName)) {
            $this->redirect("Uploader/index", "", 2, "你还没有添加视频名称");
            die;
        }
        if (empty($videoIntro)) {
            $this->redirect("Uploader/index", "", 2, "你还没有添加视频简介.");
            die;
        }
        //判断用户有没有登录
        $uid = session('uid');
        if ($uid == null) {
            $this->redirect("Passport/index", '', 2, '笨,不登录你怎么上传啊... ^_^');
        }
        //上传图片
        $upload = new \Think\Upload();// 实例化上传类
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath = './data/uploads/img/'; // 设置附件上传根目录
        $upload->subName = array('date', 'Y/m/d');
        $info = $upload->uploadOne($_FILES['cover']);
        if (!$info) {
            // 上传错误提示错误信息
            $this->error($upload->getError());
        } else {
            // 上传成功 获取上传文件信息
            $fileName = $info['savepath'] . $info['savename'];
        }
        //上传de路径
        $coverPath = substr($upload->rootPath . $fileName, 2);
        //在视频列表里添加一个视频 返回视频id
        $newVid = $videos->addVideo($videoName, $coverPath, $videoIntro, $uid);

        //循环将视频所属的cid和vid建立关联
        foreach ($cate as $cid) {
            $categroy->addCate($cid, $newVid);
        }
        //跳转到子视频上传页面
        $this->redirect("Uploader/upload", ['vid' => $newVid]);
    }

    //视频信息填好后跳转到子视频上传页面.
    public function upload()
    {
        //视频的id
        $vid = I('get.vid', 0, 'intval');
        $this->assign('vid', $vid);
        $this->display('uploader');
    }


    /**
     * 上传子视频控制器
     */
    public function uploads()
    {
        //获取视频所属的vid
        $vid = I('get.vid', 1, 'intval');
        $videosItem = D('VideosItem');

        @set_time_limit(0);//永久
        $d = date("Y-m-d");
        $data = explode('-', $d);

        //视频最后保存目录
        $uploadDir = 'data' . DIRECTORY_SEPARATOR
            . 'uploads' . DIRECTORY_SEPARATOR
            . 'videos' . DIRECTORY_SEPARATOR;
        //递归创建文件夹
        createFolder($uploadDir);
        $u = new \Think\Upload();//实例化上传类  \是初始命名空间 Think是根命名空间 Upload是类
        $u->maxSize = 1024000000;//设置文件大小
        $u->rootPath = "./";//文件存放的根路径
        $u->savePath = $uploadDir;//设置当前上传的文件存放的位置
        $u->subName = $data[0] . DIRECTORY_SEPARATOR . $data[1] . DIRECTORY_SEPARATOR . $data[2];
        $u->exts = array('mp4', 'mov');// 设置附件上传类型
        $info = $u->upload();//上传文件并返回文件信息
        if ($info) {
            $response = [
                'success' => true,
                'oldName' => $info["file"]['name'],
                'filePath' => $info["file"]['savepath'] . $info["file"]['savename'],
                'fileSize' => $info["file"]['size'],
                'fileSuffixes' => $info["file"]['ext'],
                'file_id' => $data['id'],
            ];
            //获取视频的长度
            $videoTime = getVideoTime($response['filePath']);
            //如果获取不到视频长度请尝试打开php.ini   将里面的disable_functions设置为空
            $vtime = explode('.', $videoTime['vtime']);
            //文件大小
            $videoSize = filesize($response['filePath']);
            //去掉扩展名的文件名
            $response['oldName'] = substr($response['oldName'], 0, strrpos($response['oldName'], '.'));
            /**
             * 此处执行写入数据库操作
             */
            $videosItem->upload($response['oldName'], $response['filePath'], $vtime[0], $vid, $videoSize);
            //输出成功信息
            $response['timelength'] = $vtime[0];
            die(json_encode($response));
        } else {
            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "' . $u->getError() . '."}, "id" : "id"}');
        }
    }
}
