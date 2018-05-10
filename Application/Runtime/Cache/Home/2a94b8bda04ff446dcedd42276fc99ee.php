<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>首页 - 视频分享</title>
    <link href="/Public/Home/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Home/css/comm.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon"href="/Public/Home/pic/ico.ico">
    
    <link href="/Public/Home/css/index.css" rel="stylesheet">

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
                <?php session_start();?>
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


<!--视频分类-->
<div class="container Carousel_pic">
    <div class="col-lg-3 video_classify clearfix">
        
        <div class="menuContent" id="menuContent">
            <ul>
                <?php if(is_array($categroy)): foreach($categroy as $key=>$firstCategroy): ?><li data-detail-id="menuContent_detail_<?php echo ($firstCategroy["id"]); ?>">
                        <div>
                            <a href="<?php echo U('Classify/index',['cid'=>$firstCategroy['id']]);?>" target="_blank" class="menuContent_title"><?php echo ($firstCategroy["name"]); ?></a>
                            <p class="menuContent_cont">
                                <?php if(is_array($firstCategroy["child"])): $i = 0; $__LIST__ = array_slice($firstCategroy["child"],0,3,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$twoCategroy): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Classify/index',['cid'=>$twoCategroy['id']]);?>" target="_blank"><?php echo ($twoCategroy["name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
                            </p>
                        </div>
                    </li><?php endforeach; endif; ?>
            </ul>
        </div>
       
        <?php if(is_array($categroy)): $i = 0; $__LIST__ = $categroy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$firstCategroy): $mod = ($i % 2 );++$i;?><div id="menuContent_detail_<?php echo ($firstCategroy["id"]); ?>">
                <div class="menuContent_detail_bg">
                </div>
                <div class="menuContent_detail">
                    <h3><?php echo ($firstCategroy["name"]); ?></h3>
                    <ul>
                        <?php if(is_array($firstCategroy["child"])): $i = 0; $__LIST__ = $firstCategroy["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$twoCategroy): $mod = ($i % 2 );++$i;?><li><a href="<?php echo U('Classify/index',['cid'=>$twoCategroy['id']]);?>" target="_blank" style="background-color: #<?php echo ($twoCategroy["color"]); ?>"><?php echo ($twoCategroy["name"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                    <h3>推荐课程</h3>
                    <?php if(is_array($firstRecomVideos[$firstCategroy['id']])): foreach($firstRecomVideos[$firstCategroy['id']] as $key=>$firstRecomVideo): ?><a href="<?php echo U('Detail/index',['vid'=>$firstRecomVideo['id']]);?>" target="_blank"><?php echo ($firstRecomVideo["name"]); ?></a><?php endforeach; endif; ?>
                </div>
            </div><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
    <!--轮播大图-->
    <div id="carousel-example-generic" class="carousel slide col-lg-9" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-generic" data-slide-to="1"></li>
            <li data-target="#carousel-example-generic" data-slide-to="2"></li>
        </ol>
        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            <div class="item active">
                <img src="/Public/Home/pic/big_pic1.jpg" alt="...">
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <img src="/Public/Home/pic/big_pic2.jpg" alt="...">
                <div class="carousel-caption">
                </div>
            </div>
            <div class="item">
                <img src="/Public/Home/pic/big_pic3.jpg" alt="...">
                <div class="carousel-caption">
                </div>
            </div>
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!--视频列表-->
<div class="container">
    <div class="row">
        <h2 class="video_list_name"><a>热门视频</a></h2>
        <?php if(is_array($hotVideos)): foreach($hotVideos as $key=>$val): ?><div class="col-sm-6 col-md-3 col-xs-6">
                <a href="<?php echo U('Detail/index',['vid'=>$val['id']]);?>" target="_blank" class="video_link">
                    <div class="e8-list thumbnail">
                        <img src="/<?php echo ($val["cover"]); ?>" />
                        <div class="caption">
                            <h3><?php echo ($val["name"]); ?></h3>
                            <p><?php echo ($val["intro"]); ?></p>
                            <p><?php echo (time2date($val["ctime"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;浏览量：<?php echo ($val["views"]); ?></p>
                        </div>
                    </div>
                </a>
            </div><?php endforeach; endif; ?>
    </div>
    <div class="row">
        <h2 class="video_list_name video_list_name2"><a>最新上传</a></h2>
        <?php if(is_array($newVideos)): foreach($newVideos as $key=>$val): ?><div class="col-sm-6 col-md-3 col-xs-6">
                <a href="<?php echo U('Detail/index',['vid'=>$val['id']]);?>" target="_blank" class="video_link">
                    <div class="e8-list thumbnail">
                        <img src="/<?php echo ($val["cover"]); ?>">
                        <div class="caption">
                            <h3><?php echo ($val["name"]); ?></h3>
                            <p><?php echo ($val["intro"]); ?></p>
                            <p><?php echo (time2date($val["ctime"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;浏览量：<?php echo ($val["views"]); ?></p>
                        </div>
                    </div>
                </a>
            </div><?php endforeach; endif; ?>
    </div>
</div>

<div class="container bg_pic"><div class="warp"><h2>随时不随地学</h2><p>响应式让你多终端感受智能学习体验</p></div></div>

     
<!--视频列表-->
<div class="container">
    <?php if(is_array($parentCategroys)): foreach($parentCategroys as $key=>$parentCategroy): ?><div class="row">
            <h2 class="video_list_name">
                <a href="#"><?php echo ($parentCategroy["name"]); ?></a>
            </h2>
            <?php if(is_array($firstNewVideos[$parentCategroy['id']])): foreach($firstNewVideos[$parentCategroy['id']] as $key=>$firstNewVideo): ?><div class="col-sm-6 col-md-3 col-xs-12">
                    <a href="<?php echo U('Detail/index',['vid'=>$firstNewVideo['id']]);?>" target="_blank" class="video_link">
                        <div class="e8-list thumbnail">
                            <img src="/<?php echo ($firstNewVideo["cover"]); ?>" />
                            <div class="caption">
                                <h3><?php echo ($firstNewVideo["name"]); ?></h3>
                                <p><?php echo ($firstNewVideo["intro"]); ?></p>
                                <p><?php echo (time2date($firstNewVideo["ctime"])); ?>&nbsp;&nbsp;&nbsp;&nbsp;浏览量：<?php echo ($firstNewVideo["views"]); ?></p>
                            </div>
                        </div>
                    </a>
                </div><?php endforeach; endif; ?>
        </div><?php endforeach; endif; ?>
</div>


<!--底部导航-->
<footer class="footer">
    <p class="text-center">E8net&copy;皖ICP备16000979号</p>

    <p class="small text-center">网站浏览量：<?php echo ($webView); ?></p>
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

    <script>
        $(function (){
            var currentCate = null; //当前显示的分类详情
            var menuContentLi = $("#menuContent>ul>li");
            var menuContentDetail = $(".menuContent_detail");
            var flag = false;
            menuContentDetail.mouseover(function () {
                flag = true;
            }).mouseout(function () {
                flag = false
            });
            menuContentLi.mouseenter(function (){
                var c = $('#'+$(this).attr('data-detail-id'));
                if(currentCate !=null && c != currentCate){
                    currentCate.hide();
                }
                currentCate = c;
                currentCate.show();
            });
            $(".video_classify").mouseleave(function () {
                if(!flag){
                    currentCate.hide();
                }
            });
        });
    </script>

</body>
</html>