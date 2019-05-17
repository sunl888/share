<?php


namespace Home\Controller;
/**
 * Created by PhpStorm.
 * User: 孙龙
 * Date: 2016/7/25
 * Time: 7:13
 */
class UploaderController extends BaseController{

    /**
     * 上传视频的基本信息页面
     */
    public function index(){
        $videos = D('Videos');
        $categroies = D('Categroies');

        //判断有没有登录
        if(empty($_SESSION['username'])){
            $this->redirect("Passport/index","",2,"亲,想上传视频请先登录喔");
        }
        //获取所有视频分类
        $categroy = $categroies->getAllCategroy();
        $this->assign('categroy',$categroy);
        $this->display();
    }
    /**
     * 提交要上传视频的基本信息
     */
    public function uploadVideoInfo(){

        $categroy = D('Categroies');
        $videos = D('Videos');

        $cate = array();
        $cate = $_POST['categroy'];
        if($cate===null){
            $this->redirect("Uploader/index","",2,"你还没有选择视频分类");
            die;
        }
        //过滤不安全的标签
        $videoName = I('post.videoName','','safetyHtml');
        $videoIntro =I('post.videoIntro','','safetyHtml');
        if(empty($videoName)){
            $this->redirect("Uploader/index","",2,"你还没有添加视频名称");
            die;
        }
        if(empty($videoIntro)){
            $this->redirect("Uploader/index","",2,"你还没有添加视频简介.");
            die;
        }
        //判断用户有没有登录
        $uid = session('uid');
        if($uid == null){
            $this->redirect("Passport/index",'',2,'笨,不登录你怎么上传啊... ^_^');
        }
        //上传图片
        $upload            =     new \Think\Upload();// 实例化上传类
        $upload->exts      =     array('jpg', 'gif', 'png','jpeg');// 设置附件上传类型
        $upload->rootPath  =     './data/uploads/img/'; // 设置附件上传根目录
        $upload->subName   =     array('date', 'Y/m/d');
        $info              =     $upload->uploadOne($_FILES['cover']);
        if(!$info) {
            // 上传错误提示错误信息
            $this->error($upload->getError());
        }else{
            // 上传成功 获取上传文件信息
            $fileName = $info['savepath'].$info['savename'];
        }
        //上传de路径
        $coverPath = substr($upload->rootPath.$fileName,2);
        //在视频列表里添加一个视频 返回视频id
        $newVid = $videos->addVideo($videoName,$coverPath,$videoIntro,$uid);

        //循环将视频所属的cid和vid建立关联
        foreach($cate as $cid){
            $categroy->addCate($cid,$newVid);
        }
        //跳转到子视频上传页面
        $this->redirect("Uploader/upload",['vid'=>$newVid]);
    }

    //视频信息填好后跳转到子视频上传页面.
    public function upload(){
        //视频的id
        $vid = I('get.vid',0,'intval');
        $this->assign('vid',$vid);
        $this->display('uploader');
    }


    /**
     * 上传子视频控制器
     */
    public function uploads(){
        //获取视频所属的vid
        $vid = I('get.vid',1,'intval');
        $videosItem = D('VideosItem');

        //上传文件
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            exit; // finish preflight CORS requests here
        }
        if ( !empty($_REQUEST[ 'debug' ]) ) {
            $random = rand(0, intval($_REQUEST[ 'debug' ]) );
            if ( $random === 0 ) {
                header("HTTP/1.0 500 Internal Server Error");
                exit;
            }
        }

        @set_time_limit(0);//永久
        //DIRECTORY_SEPARATOR用来区分windows和Linux里文件路径的斜杠
        $d = date("Y-m-d");
        $data = explode('-',$d);

        //临时目录
        $targetDir = 'data'.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'file_temp';
        //视频最后保存目录
        $uploadDir = 'data'.DIRECTORY_SEPARATOR
            .'uploads'.DIRECTORY_SEPARATOR
            .'videos'.DIRECTORY_SEPARATOR
            .$data[0].DIRECTORY_SEPARATOR
            .$data[1].DIRECTORY_SEPARATOR
            .$data[2];
        createFolder($targetDir);
        //递归创建文件夹
        createFolder($uploadDir);

        $cleanupTargetDir = true; // Remove old files
        $maxFileAge = 5 * 3600; // Temp file age in seconds
        // Get a file name
        if (isset($_REQUEST["name"])) {
            $fileName = $_REQUEST["name"];
        } elseif (!empty($_FILES)) {
            $fileName = $_FILES["file"]["name"];
        } else {

            $fileName = uniqid("file_");
        }

        $oldName = $fileName;


        //$filePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
        //不能直接用中文文件名保存数据 应该将上传的文件改成英文名称再执行保存命令
        $filePath = $targetDir . DIRECTORY_SEPARATOR . uniqid('wq_');

        // Chunking might be enabled
        $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
        $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
        // Remove old temp files

        if ($cleanupTargetDir) {
            if (!is_dir($targetDir) || !$dir = opendir($targetDir)) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 100, "message": "Failed to open temp directory."}, "id" : "id"}');
            }

            while (($file = readdir($dir)) !== false) {
                $tmpfilePath = $targetDir . DIRECTORY_SEPARATOR . $file;
                // If temp file is current file proceed to the next
                if ($tmpfilePath == "{$filePath}_{$chunk}.part" || $tmpfilePath == "{$filePath}_{$chunk}.parttmp") {
                    continue;
                }
                // Remove temp file if it is older than the max age and is not the current file
                if (preg_match('/\.(part|parttmp)$/', $file) && (@filemtime($tmpfilePath) < time() - $maxFileAge)) {

                    @unlink($tmpfilePath);
                }
            }
            closedir($dir);
        }
        // Open temp file
        $out = fopen("{$filePath}_{$chunk}.parttmp", "wb");
        if ($out === FALSE) {

            die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
        }

        if (!empty($_FILES)) {
            if ($_FILES["file"]["error"] || !is_uploaded_file($_FILES["file"]["tmp_name"])) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
            }
            // Read binary input stream and append it to temp file
            if (!$in = @fopen($_FILES["file"]["tmp_name"], "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        } else {
            if (!$in = @fopen("php://input", "rb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
            }
        }
        while ($buff = fread($in, 4096)) {
            fwrite($out, $buff);
        }
        @fclose($out);
        @fclose($in);
        rename("{$filePath}_{$chunk}.parttmp", "{$filePath}_{$chunk}.part");
        $index = 0;
        $done = true;
        for( $index = 0; $index < $chunks; $index++ ) {
            if ( !file_exists("{$filePath}_{$index}.part") ) {
                $done = false;
                break;
            }
        }
        if ( $done ) {
            $pathInfo = pathinfo($fileName);
            $hashStr = substr(md5($pathInfo['basename']),8,16);
            $hashName = time() . $hashStr . '.' .$pathInfo['extension'];
            $uploadPath = $uploadDir . DIRECTORY_SEPARATOR .$hashName;
            //p($uploadPath);
            if (!$out = @fopen($uploadPath, "wb")) {
                die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
            }
            if ( flock($out, LOCK_EX) ) {
                for( $index = 0; $index < $chunks; $index++ ) {
                    if (!$in = @fopen("{$filePath}_{$index}.part", "rb")) {
                        break;
                    }
                    while ($buff = fread($in, 4096)) {
                        fwrite($out, $buff);
                    }
                    @fclose($in);
                    @unlink("{$filePath}_{$index}.part");
                }
                flock($out, LOCK_UN);
            }
            @fclose($out);



            $response = [
                'success'=>true,
                'oldName'=>$oldName,
                'filePath'=>$uploadPath,
                'fileSize'=>$data['size'],
                'fileSuffixes'=>$pathInfo['extension'],
                'file_id'=>$data['id'],
            ];

            //获取视频的长度
            $videoTime = getVideoTime($response['filePath']);
            //如果获取不到视频长度请尝试打开php.ini   将里面的disable_functions设置为空
            $vtime = explode('.' , $videoTime['vtime'] );
            //文件大小
            $videoSize = filesize($response['filePath']);
            //去掉扩展名的文件名
            $response['oldName'] = substr($response['oldName'],0,strrpos($response['oldName'], '.'));
            /**
             * 此处执行写入数据库操作
             */
            $videosItem->upload($response['oldName'],$response['filePath'],$vtime[0],$vid,$videoSize);
            //输出成功信息
            $response['timelength'] = $vtime[0];
            die(json_encode($response));
        }
        die('{"jsonrpc" : "2.0", "result" : null, "id" : "id"}');
    }
}
