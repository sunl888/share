<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>视频详情 - E8资料分享</title>
    <link href="/share/Public/Home/css/bootstrap.min.css" rel="stylesheet">
    <link href="/share/Public/Home/css/comm.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon"href="/share/Public/Home/pic/ico.ico">
    
    <link href="/share/Public/Home/css/detail.css" rel="stylesheet">

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
                    <button type="button" id="register" class="btn btn-primary" data-container="body" data-toggle="popover" data-placement="bottom" data-content="sorry! The register function only open by E8 member.">
                        注册
                    </button>
                 <?php else: ?> 
                    <a href="<?php echo U('Passport/unLogin');?>" title="退出登录" role="button" class="btn btn-default"><?php echo ($_SESSION['username']); ?></a>
                    <a href="<?php echo U('Uploader/index');?>" target="_blank" type="button" id="register" class="btn btn-primary" data-container="body" data-toggle="popover" data-placement="bottom">
                        上传
                    </a><?php endif; ?>
            </div>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>

    
<!--巨幕-->
<div class="jumbotron">
  <div class="container">
    <h1><?php echo ($videoInfo["name"]); ?></h1>
    <p><?php echo ($videoInfo["intro"]); ?></p>
  </div>
</div>

<!--列表-->
<div class="container video_list">
  <ol class="breadcrumb Route">
      <li><a href="<?php echo U('Classify/index');?>">Home</a></li>
    <li><a href="<?php echo U('Classify/index',['cid'=>$parentCate['id']]);?>"><?php echo ($parentCate["name"]); ?></a></li>
    <li class="active"><?php echo ($videoInfo["name"]); ?></li>
  </ol>
  <div class="list-group">
    <a href="#" class="list-group-item active">
      <?php echo ($videoInfo["name"]); ?>
    </a>
      <?php if(is_array($videoItem)): foreach($videoItem as $key=>$val): ?><div href="#" class="list-group-item clearfix">
            <p class="col-lg-2 col-md-2 col-xs-2"><?php echo ($key+1); ?></p>
            <p class="col-lg-7 col-md-7 col-xs-7"><a href="<?php echo U('Play/index',['vItemid'=>$val['id'],'vid'=>$videoInfo['id']]);?>"><?php echo ($val["name"]); ?></a></p>
            <p class="col-lg-2 col-md-2 col-xs-2"><?php echo ($val["timelength"]); ?></p>
            <a href="<?php echo U('Base/down',['vItem'=>$val['id']]);?>" title="下载" class="glyphicon glyphicon-download-alt col-lg-1 col-md-1 col-xs-1"></a>
           </div><?php endforeach; endif; ?>
  </div>
</div>
<!--相关推荐-->
<div class="recommend">
  <div class="container">
    <div class="row">
      <h2 class="video_list_name"><a>猜你喜欢</a></h2>
      <?php if(is_array($relaVideos)): foreach($relaVideos as $key=>$val): ?><div class="col-sm-6 col-md-3 col-xs-6">
            <a href="#">
              <div class="e8-list thumbnail">
                <img src="/share/<?php echo ($val["cover"]); ?>">
                <div class="caption">
                  <h3><?php echo ($val["name"]); ?></h3>
                  <p><?php echo ($val["intro"]); ?></p>
                  <p><?php echo (time2date($val["ctime"])); ?></p>
                </div>
              </div>
            </a>
          </div><?php endforeach; endif; ?>
    </div>
  </div>
</div>

<!--底部导航-->
<footer class="footer">
    <p class="text-center">&copy;E8net-3t小组</p>
</footer>
<!--回到顶部-->
<div class="onTop" id="onTop"><span>回到<br />顶部<span></div>
<!--js-->
<script src="/share/Public/Home/js/jquery-2.1.4.js"></script>
<script src="/share/Public/Home/js/bootstrap.min.js"></script>
<script src="/share/Public/Home/js/comm.js"></script>
<script>
    console.log("%c本网站所有视频均免费,无需注册即可观看.","color:#f30;");
    console.log("%chttp://home.coder4me.cn","background: rgba(252,234,187,1);background: -moz-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%,rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: -webkit-gradient(left top, right top, color-stop(0%, rgba(252,234,187,1)), color-stop(12%, rgba(175,250,77,1)), color-stop(28%, rgba(0,247,49,1)), color-stop(39%, rgba(0,210,247,1)), color-stop(51%, rgba(0,189,247,1)), color-stop(64%, rgba(133,108,217,1)), color-stop(78%, rgba(177,0,247,1)), color-stop(87%, rgba(247,0,189,1)), color-stop(100%, rgba(245,22,52,1)));background: -webkit-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: -o-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: -ms-linear-gradient(left, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);background: linear-gradient(to right, rgba(252,234,187,1) 0%, rgba(175,250,77,1) 12%, rgba(0,247,49,1) 28%, rgba(0,210,247,1) 39%, rgba(0,189,247,1) 51%, rgba(133,108,217,1) 64%, rgba(177,0,247,1) 78%, rgba(247,0,189,1) 87%, rgba(245,22,52,1) 100%);filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#fceabb', endColorstr='#f51634', GradientType=1 );font-size:1.6em;text-decoration:none;")
</script>

</body>
</html>