<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html>
<head>
    <title>E8内部分享</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <link rel="stylesheet" href="/Public/Mobile/css/weui.min.css">
    <link rel="stylesheet" href="/Public/Mobile/css/jquery-weui.min.css">
    <link rel="stylesheet" href="/Public/Mobile/css/comm.css">
    
    <script type="text/javascript" src="/Public/Mobile/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="/Public/Mobile/js/jquery-weui.min.js"></script>
</head>

<body>
           <link rel="stylesheet" href="/Public/Mobile/css/index.css"> 
       <!--header-->
        <header class="topBar">
            <a href="#">
                <i class="iconfont icon-fenlei" onclick="classify_open()"></i>
                <h2 onclick="classify_open()">分类</h2>
            </a>
            <?php if(!isset($_SESSION['username'])): ?><a href="<?php echo U('Passport/index');?>" class="index_login">登录</a>
             <?php else: ?> 
                <a href="<?php echo U('Passport/unLogin');?>" class="index_login"><?php echo ($_SESSION['username']); ?></a><?php endif; ?>
            <!--搜索按钮-->
            <i class="iconfont icon-sousu" id="search_open_btn"></i>
        </header> 
       <!--Slide-->
        <div class="swiper-container" data-space-between='10' data-pagination='.swiper-pagination' data-autoplay="1000">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/Public/Mobile/pic/slide1.gif" alt=""></div>
                <div class="swiper-slide"><img src="/Public/Mobile/pic/slide2.jpg" alt=""></div>
                <div class="swiper-slide"><img src="/Public/Mobile/pic/slide3.jpg" alt=""></div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
       
        <!--热门视频-->
        <div class="weui_panel weui_panel_access">
            <div class="weui_panel_hd">热门视频</div>
            <div class="weui_panel_bd">
                <?php if(is_array($hotVideos)): foreach($hotVideos as $key=>$vo): ?><a href="<?php echo U('Play/getVideosItem',['vid'=>$vo['id'] ]);?>" class="weui_media_box weui_media_appmsg">
                        <div class="weui_media_hd">
                            <img class="weui_media_appmsg_thumb" src="/<?php echo ($vo["cover"]); ?>" alt="">
                        </div>
                        <div class="weui_media_bd">
                            <h4 class="weui_media_title"><?php echo ($vo["name"]); ?></h4>
                            <p class="weui_media_desc"><?php echo ($vo["intro"]); ?></p>
                        </div>
                    </a><?php endforeach; endif; ?>
            </div>
            <a class="weui_panel_ft" href="<?php echo U('List/findMore',['flag'=>0]);?>">查看更多</a>
        </div>
        <!--最新上传-->
        <div class="weui_panel weui_panel_access">
            <div class="weui_panel_hd">最新上传</div>
            <div class="weui_panel_bd">
                <?php if(is_array($newVideos)): foreach($newVideos as $key=>$vo): ?><a href="<?php echo U('Play/getVideosItem',['vid'=>$vo['id'] ]);?>" class="weui_media_box weui_media_appmsg">
                        <div class="weui_media_hd">
                            <img class="weui_media_appmsg_thumb" src="/<?php echo ($vo["cover"]); ?>" alt="">
                        </div>
                        <div class="weui_media_bd">
                            <h4 class="weui_media_title"><?php echo ($vo["name"]); ?></h4>
                            <p class="weui_media_desc"><?php echo ($vo["intro"]); ?></p>
                        </div>
                    </a><?php endforeach; endif; ?>
            </div>
            <a class="weui_panel_ft" href="<?php echo U('List/findMore',['flag'=>1]);?>">查看更多</a>
        </div>
        
        <!--搜索页面-->
        <section class="search" id="search">
            <header class="topBar">
                <a href="#">
                    <i class="iconfont icon-jiantou1" id="search_close_btn"></i>
                </a>
                <input id="search_input" type="search" placeholder="搜索资料"/>
                <i class="iconfont icon-sousu"></i>
            </header>
            <section class="search_body">
                <ul id="search_resule">
                    <li>热门搜索</li>
                    <?php if(is_array($hotSearch)): foreach($hotSearch as $key=>$item): ?><li><a href="<?php echo U('Play/getVideosItem',['vid'=>$item['id']]);?>">
                             <?php echo ($item["name"]); ?>
                         </a></li><?php endforeach; endif; ?>
                </ul>
            </section>
        </section>
        
        <!--分类页面-->
        <section class="classify" id="classify">
            <header class="topBar">
                <a href="#">
                    <i class="iconfont icon-jiantou1" id="classify_close"></i>
                </a>
                <h2>分类</h2>
            </header>
            <!--分类-->
            <div style="overflow-y: scroll;" id="classify_div">
            <section class="classify-body">
                <a href="<?php echo U('List/getAllVideos');?>">全部课程</a>
                <?php if(is_array($categroy)): foreach($categroy as $key=>$cate): ?><h3><?php echo ($cate["name"]); ?></h3>
                    <ul>
                        <?php if(is_array($cate["child"])): foreach($cate["child"] as $key=>$val): ?><li><a href="<?php echo U('List/categroyVideos',['cid'=>$val['id']]);?>" style="background-color: #<?php echo ($val["color"]); ?>"><?php echo ($val["name"]); ?></a></li><?php endforeach; endif; ?>
                    </ul><?php endforeach; endif; ?>
            </section>
            </div>
        </section>
        <script type="text/javascript" src="/Public/Mobile/js/jquery-2.1.4.js"charset="utf-8"></script>
        <script type="text/javascript" src="/Public/Mobile/js/jquery-weui.min.js"charset="utf-8"></script>
        <script type="text/javascript" src="/Public/Mobile/js/swiper.min.js"charset="utf-8"></script>
        <script>
            (function ($){
                $(function(){
                    //轮播图初始化
                    $(".swiper-container").swiper({
                        loop : true,
                        autoplay : 3000,
                        pagination:$('.swiper-pagination'),
                    })
                    //搜索页面切换
                    var searchSection = $("#search");
                    $("#search_open_btn").click(function(){
                        searchSection.show(0,function(){
                            searchSection.css({
                                "transform":"translate(0,0)"
                            })
                        });
                    })
                    $("#search_close_btn").click(function(){
                        searchSection.css({
                            "transform":"translate(100%,0)"
                        });
                        setTimeout(function(){
                            searchSection.hide(0)
                        },600)
                    })
                    //分类页面
                    var classifySection = $("#classify");
                    classifySection.on('touchmove',function(event){
                        stopBubble(event);
                    })
                    window.classify_open = function(){
                        classifySection.show(0,function(){
                            classifySection.css({
                                "transform":"translate(0,0)"
                            })
                        });
                        document.body.style.overflow="hidden";
                    }
                    $("#classify_close").click(function(){
                        classifySection.css({
                            "transform":"translate(-100%,0)"
                        });
                        setTimeout(function(){
                            classifySection.hide(0)
                        },600)
                        document.body.style.overflow="auto";
                    })
                    $("#classify_div").css('height',document.body.clientHeight-50);
                    //处理搜索
                    var searchResuleUl = $('#search_resule');
                    $('#search_input').keyup(function(event){
                        
                        $.get("<?php echo U('search');?>",{name: $(this).val()},function(data){
                            if(data != ''){
                                searchResuleUl.html(data);
                            }else{
                                searchResuleUl.html('<li>相关内容</li>');
                            }
                        });
                    });
                });
            })(jQuery)
            function stopBubble(e) {
                //如果提供了事件对象，则这是一个非IE浏览器
                if ( e && e.stopPropagation )
                    //因此它支持W3C的stopPropagation()方法
                    e.stopPropagation();
                else
                    //否则，我们需要使用IE的方式来取消事件冒泡
                    window.event.cancelBubble = true;
            }
        </script>

    <p class="watermark">E8net-3T小组</p>
</body>
</html>