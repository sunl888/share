<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>全部视频 - 视频分享</title>
    <link href="/Public/Home/css/bootstrap.min.css" rel="stylesheet">
    <link href="/Public/Home/css/comm.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon"href="/Public/Home/pic/ico.ico">
    
    <link href="/Public/Home/css/classify.css" rel="stylesheet">

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

<!--分类列表-->
<div class="container classify_body">
    <h2>全部课程</h2>
    <div class="main">
        <div class="classify_direction">
            <span>方向:</span>
            <ul>
                
                <li><a href="<?php echo U('Classify/index');?>" <?php if(($parentCateId) == "0"): ?>class="active"<?php endif; ?>>全部</a></li>
                <?php if(is_array($allCate)): foreach($allCate as $key=>$cate): ?><li><a <?php if(($parentCateId) == $cate['id']): ?>class="active"<?php endif; ?> href="<?php echo U('Classify/index',['cid'=>$cate['id']]);?>"><?php echo ($cate["name"]); ?></a></li><?php endforeach; endif; ?>
            </ul>
        </div>
        <div class="classify_body_classify">
            <span>分类:</span>
            <ul>
                <li><a <?php if(($childCateId) == "0"): ?>class="active"<?php endif; ?> href="<?php echo U('Classify/index',['cid'=>$child['id']]);?>" >全部</a></li>
                <?php if(is_array($childCate)): foreach($childCate as $key=>$child): ?><li><a <?php if(($childCateId) == $child['id']): ?>class="active"<?php endif; ?> href="<?php echo U('Classify/index',['cid'=>$child['id']]);?>" ><?php echo ($child['name']); ?></a></li><?php endforeach; endif; ?>
                
            </ul>
        </div>
        <div class="classify_sort">
            <?php $arg['hot'] = $cid==0?['sort'=>'hot']:['cid'=>$cid,'sort'=>'hot']; $arg['new'] = $cid==0?['sort'=>'new']:['cid'=>$cid,'sort'=>'new']; ?>
            
            <?php if($sort == 'new' ): ?><a href="<?php echo U('Classify/index',$arg['new']);?>" class="sort_active">最新</a>
                <a href="<?php echo U('Classify/index',$arg['hot']);?>">最热</a>
                <?php else: ?> 
                <a href="<?php echo U('Classify/index',$arg['new']);?>" >最新</a>
                <a href="<?php echo U('Classify/index',$arg['hot']);?>" class="sort_active">最热</a><?php endif; ?>
           <!-- <ul>
                <li><a href="#">上一页</a></li>
                <li><a href="#">下一页</a></li>
            </ul>-->
        </div>
    </div>
</div>

<!--视频列表-->
<div class="container">
    <?php $end = count($videosList); ?>
    <?php $__FOR_START_407245500__=0;$__FOR_END_407245500__=$end;for($i=$__FOR_START_407245500__;$i < $__FOR_END_407245500__;$i+=1){ if($i%4==0){ ?>
            <div class="row">
        <?php } ?>
        <div class="col-sm-6 col-md-3 col-xs-6">
            <a href="<?php echo U('Detail/index',['vid'=>$videosList[$i]['id']]);?>" target="_blank">
                <div class="e8-list thumbnail">
                    <img src="/<?php echo ($videosList[$i]["cover"]); ?>" />
                    <div class="caption">
                        <h3><?php echo ($videosList[$i]["name"]); ?></h3>
                        <p><?php echo ($videosList[$i]["intro"]); ?></p>
                        <p><?php echo (time2date($videosList[$i]["ctime"])); ?></p>
                    </div>
                </div>
            </a>
        </div>
        
        <?php if($i%4==3){ ?>
            </div>
        <?php } } ?>
        <?php if($end%4!=0){ ?>
            </div>
        <?php } ?>
    <!--分页-->
    <nav class="text-center">
        <?php echo ($page->show()); ?>
    </nav>
</div>

<script>
    window.onload = function(){
        var OnTop = document.getElementById('onTop');
        window.onscroll = function (){
            if(document.body.scrollTop>200){
                OnTop.style.display="block";
            }else{
                OnTop.style.display="none";
            }
        }
        var clientHeight = document.body.clientHeight;
        OnTop.onclick = function(){
            var timer = setInterval(function(){
                if(document.body.scrollTop>0){
                    document.body.scrollTop-=(clientHeight-document.body.scrollTop)/30
                }else{
                    clearInterval(timer)
                }
            },10)
        }
    }
    $(function(){
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

</body>
</html>