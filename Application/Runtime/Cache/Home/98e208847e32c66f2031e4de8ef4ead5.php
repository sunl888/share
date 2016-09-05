<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>3T搜索 - E8资料分享</title>
    <link href="/share/Public/Home/css/bootstrap.min.css" rel="stylesheet">
    <link href="/share/Public/Home/css/comm.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon"href="/share/Public/Home/pic/ico.ico">
    
    <link href="/share/Public/Home/css/search.css" rel="stylesheet">

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

<!--搜索-->
<div class="search_container">
    <div class="text-center search_logo"><img src="/share/Public/Home/pic/search_logo.png"></div>
    <div class="search_banner text-center">
        <form method="GET" action="<?php echo U('Search/index');?>">
            <input type="search" name="keyword" autocomplete="off" value="<?php echo ($keyword); ?>" placeholder="请输入关键字" id="search_box"/>
            <span class="glyphicon glyphicon-remove delete_text" id="clear_text" aria-hidden="true"></span>
            <input type="submit" value="搜索"/>
            <div class="search_tip" id="search_tip">
                <ul id="search_tip_ul">
                </ul>
            </div>
        </form>
    </div>
    <div class="search_main"></div>
</div>
<!--搜索列表-->
<div class="search_list">
    <div class="container">
        <ol class="breadcrumb Route">
            <li><a href="<?php echo U('Index/index');?>">首页</a></li>
            <li><a href="<?php echo U('Search/index');?>">搜索</a></li>
            <li class="active">"<b style="color:#f30;"><?php echo ($keyword); ?></b>" 相关结果</li>
        </ol>
        <div class="search_list_main col-lg-8">
            <?php $end = count($find); ?>
            <?php $__FOR_START_1627216907__=0;$__FOR_END_1627216907__=$end;for($i=$__FOR_START_1627216907__;$i < $__FOR_END_1627216907__;$i+=1){ if($i%3==0){ ?>
                    <div class="row">
                <?php } ?>
            <div class="col-sm-4 col-md-4 col-xs-6">
                <a href="<?php echo U('Detail/index',['vid'=>$find[$i]['id']]);?>">
                     <div class="e8-list thumbnail">
                         <img src="/share/<?php echo ($find[$i]["cover"]); ?>">
                         <div class="caption">
                             <h3><?php echo ($find[$i]["name"]); ?></h3>
                             <p> <?php echo ($find[$i]["intro"]); ?>  </p>
                             <p><?php echo (time2date($find[$i]["ctime"])); ?></p>
                         </div>
                     </div>
                 </a>
             </div> 
            <?php if($i%3==2){ ?>
                </div>
            <?php } } ?>
            <?php if($end%3!=0){ ?>
                </div>
            <?php } ?>
        </div>
        <!--热门搜索-->
        <div class="hot_search visible-lg-block col-lg-4">
            <h3>热门搜索</h3>
            <ul>
                <?php if(is_array($childCate)): foreach($childCate as $key=>$val): ?><li><a href="<?php echo U('Classify/index',['cid'=>$val['id']]);?>" style="background-color: #<?php echo ($val["color"]); ?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; ?>
            </ul>
        </div>
    </div>
    <!--分页-->
    <nav class="text-center">
        <?php echo ($page->show()); ?>
    </nav>
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

<script>
    $(function () {
        
        //输入框
        var searchBox = $("#search_box");
        var clearText = $("#clear_text");
        var searchTip = $("#search_tip");
		var searchTipUl = $("#search_tip_ul");
        searchBox.keyup(function(){
            if(searchBox.val() != ''){
                clearText.fadeIn(150);
                searchTip.fadeIn(150);
            }
            else {
                clearText.fadeOut(150);
                searchTip.fadeOut(150);
            }
            $.get("<?php echo U('Home/Search/search');?>?name=" + searchBox.val(),function(data){
                searchTipUl.html(data);
            })
        });
        clearText.click(function () {
            searchBox.val('');
            clearText.fadeOut(150);
            searchTip.fadeOut(150);
        });
        
         // 彩蛋
         var keyword = '<?php echo ($keyword); ?>';
         var jBody = $('body');
         if(keyword === '旋转'){
             jBody.css('transform', 'rotate(360deg)');
         }
         if(keyword === '翻转'){
             jBody.css('transform', 'rotateY(360deg)');
         }
         if(keyword === '3t'){
             var times = 0;
            var timer = setInterval(function(){
                if(times++<10){
                    jBody.toggle()
                }else{
                    clearInterval(timer)
                }
            },100)
         }
    })
</script>

</body>
</html>