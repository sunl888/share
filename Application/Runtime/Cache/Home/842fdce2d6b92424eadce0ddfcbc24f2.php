<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>视频上传 - 视频分享</title>
    <link href="/Public/Home/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Home/css/comm.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon"href="/Public/Home/pic/ico.ico">
    
    <link href="/Public/Home/css/webuploader.css" rel="stylesheet">

</head>
<body>
<!--导航栏-->
<nav class="navbar e8-nav navbar-inverse">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo U('Index/index');?>">E8</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <form action="<?php echo U('Search/index');?>" method="GET" class="navbar-form navbar-left" target= "_blank" role="search">
                <div class="input-group">
                    <input type="text" name="keyword" class="form-control search_box" placeholder="请输入关键字">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </span>
                </div>
            </form>
            <div class="btn-group pull-right login-btn" role="group" aria-label="...">
                <?php if(!isset($_SESSION['username'])): ?><a href="<?php echo U('Passport/index');?>" role="button" class="btn btn-default">登录</a>
                    <!--
                    <button type="button" id="register" class="btn btn-primary" data-container="body" data-toggle="popover" data-placement="bottom" data-content="sorry! The register function only open by E8 member.">
                        注册
                    </button>
                    -->
                    <a class="btn btn-primary" href="<?php echo U('Passport/regisger');?>" role="button">
                        注册
                    </a>
                 <?php else: ?> 
                    <a href="<?php echo U('Passport/unLogin');?>" title="退出登录" role="button" class="btn btn-default"><?php echo ($_SESSION['username']); ?></a>
                    <a href="<?php echo U('Uploader/index');?>" target="_blank" type="button" id="register" class="btn btn-primary" data-container="body" data-toggle="popover" data-placement="bottom">
                        上传
                    </a><?php endif; ?>
            </div>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>

<!-- 上传页面 -->
<div id="uploader" class="wu-example container up_file_mian">
    <h3 class="text-center">视频上传</h3>
    <!--用来存放文件信息-->
    <div class="uploader-list">
        <table class="table">
        <thead>
            <tr>
                <th>文件名</th>
                <th>大小</th>
                <th>类型</th>
                <th>状态</th>
                <th>进度</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody id="thelist">
        </tbody>
        </table>
    </div>
    <div class="btns">
        <div id="picker" class="choose_file">选择文件</div>
        <button id="ctlBtn" class="btn btn-default start_upload">开始上传</button>
    </div>
</div>

<!--底部导航-->
<footer class="footer">
    <p class="text-center">E8net&copy;皖ICP备16000979号</p>
</footer>
<!--回到顶部-->
<div class="onTop" id="onTop"><span>回到<br />顶部<span></div>
<!--js-->
<script src="/Public/Home/js/jquery-2.1.4.js"></script>
<script src="/Public/Home/js/bootstrap.min.js"></script>
<script src="/Public/Home/js/comm.js"></script>
<script>
    console.log("%c本网站所有视频均免费,无需注册即可观看.","color:#f30;");
    console.log("%chttp://home.coder4me.cn","background: rgba(252,234,187,1);background: -moz-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%,rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: -webkit-gradient(left top, right top, color-stop(0%, rgba(252,234,187,1)), color-stop(12%, rgba(175,250,77,1)), color-stop(28%, rgba(0,247,49,1)), color-stop(39%, rgba(0,210,247,1)), color-stop(51%, rgba(0,189,247,1)), color-stop(64%, rgba(133,108,217,1)), color-stop(78%, rgba(177,0,247,1)), color-stop(87%, rgba(247,0,189,1)), color-stop(100%, rgba(245,22,52,1)));background: -webkit-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: -o-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: -ms-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: linear-gradient(to right, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fceabb', endColorstr='#f51634', GradientType=1 );font-size:1.6em;text-decoration:none;")
</script>

<script src="/Public/Home/js/webuploader.min.js"></script>
<script>
 $(function(){
    var $list = $('#thelist');
    var uploader = WebUploader.create({

        // swf文件路径
        swf: '/Public/Home/js/Uploader.swf',
        chunked: false,
        // 文件接收服务端。
        //server: 'http://webuploader.duapp.com/server/fileupload.php',
        server: "<?php echo U('Uploader/uploads',['vid'=>$vid]);?>",
        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#picker',
        //限制每次只允许上传一个文件
	threads: 1,
       //是否允许在文件传输时提前把下一个文件准备好
	prepareNextFile: true,
        // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
        resize: false
    });
    // 当有文件被添加进队列的时候
    uploader.on( 'fileQueued', function( file ) {
        $list.append( '<tr id='+ file.id +'><td>'+file.name
                +'</td><td>'+(file.size/1048576).toFixed(2)
                +'MB</td><td>'+file.type
                +'</td><td class="statusText">'+file.statusText
                +'</td><td class="status">0%</td><td><button onclick="removeThisFile(this)" class="btn btn-default btn-xs"><i class="glyphicon glyphicon-trash"></i></button></td></tr>' );
    });
    // 文件上传过程中创建进度条实时显示。
    uploader.on( 'uploadProgress', function( file, percentage ) {
        $( '#'+file.id ).find('.status').html((percentage*100).toFixed(2) + '%');
    });
    //文件成功、失败处理
    uploader.on( 'uploadSuccess', function( file ) {
        $( '#'+file.id ).find('.statusText').text('已上传');
    });

    uploader.on( 'uploadError', function( file ) {
        $( '#'+file.id ).find('.statusText').text('上传出错');
    });
    // 上传
    $('#ctlBtn').click(function () {
        uploader.upload()
    });
    // 移除文件
    window.removeThisFile = function (elem) {
        var fildId = $(elem).parent().parent().attr('id');
        $('#'+fildId).remove();
        uploader.removeFile(fildId, true);
    }
 });
</script>

</body>
</html>