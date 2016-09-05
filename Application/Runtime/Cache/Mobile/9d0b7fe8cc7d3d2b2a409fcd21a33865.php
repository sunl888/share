<?php if (!defined('THINK_PATH')) exit();?><!Doctype html>
<html>
<head>
    <title>E8内部分享</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    
    <link rel="stylesheet" href="/share/Public/Mobile/css/weui.min.css">
    <link rel="stylesheet" href="/share/Public/Mobile/css/jquery-weui.min.css">
    <link rel="stylesheet" href="/share/Public/Mobile/css/comm.css">
    
    <script type="text/javascript" src="/share/Public/Mobile/js/jquery-2.1.4.js"></script>
    <script type="text/javascript" src="/share/Public/Mobile/js/jquery-weui.min.js"></script>
</head>

<body>
    <link rel="stylesheet" href="/share/Public/Mobile/css/play.css">
<link rel="stylesheet" href="/share/Public/Mobile/css/zy.media.min.css">

<header class="topBar">
    <a href="<?php echo U('List/categroyVideos',['cid'=>$cid]);?>">
        <i class="iconfont icon-jiantou1"></i>
        <h2><?php echo ($videosInfo["name"]); ?></h2>
    </a>
    <?php if(($isLike == 0) ): ?><i class="unlike iconfont icon-shoucangcang" id="collect"></i>
     <?php else: ?>
        <i class="unlike iconfont icon-shoucangcang liked" id="collect"></i><?php endif; ?>
</header>
<!--播放器-->
    <div class="zy_media">
        <video poster="/share/<?php echo ($videosInfo['cover']); ?>" data-config='{"mediaTitle": "<?php echo $videosItemInfo[$vItemid]['name'] ?>"}'>
            <source src="/share/<?php echo ($videosItemInfo[$vItemid]["addr"]); ?>" type="video/mp4">
            <source src="/share/<?php echo ($videosItemInfo[$vItemid]["addr"]); ?>" type="video/wmv">
        </video>
    </div>

    <!--详情-->
    <div class="weui_tab">
        <div class="weui_navbar">
            <a href="#tab1" class="weui_navbar_item weui_bar_item_on">
                章节
            </a>
            <a href="#tab2" class="weui_navbar_item">
                详情
            </a>
        </div>
        <div class="weui_tab_bd">
            <div id="tab1" class="weui_tab_bd_item weui_tab_bd_item_active">
                <div class="chapter">
                    <ul>
                        <?php $i=1; ?>
                        <?php if(is_array($videosItemInfo)): foreach($videosItemInfo as $key=>$vo): if($vo["id"] == $vItemid): ?><li>
                                        <a class="current_play" href="<?php echo U('Play/getVideosItem',['vid'=>$videosInfo['id'],'vitemid'=>$vo['id']]);?>">
                                            <span><?php echo ($i++); ?></span>
                                            <span class="chapter_name "><?php echo ($vo["name"]); ?></span>
                                            <span class="chapter_time "><?php echo ($vo["timelength"]); ?></span>
                                        </a>
                                    </li>
                                <?php else: ?>
                                    <li>
                                        <a href="<?php echo U('Play/getVideosItem',['vid'=>$videosInfo['id'],'vitemid'=>$vo['id']]);?>">
                                            <span><?php echo ($i++); ?></span>
                                            <span class="chapter_name"><?php echo ($vo["name"]); ?></span>
                                            <span class="chapter_time"><?php echo ($vo["timelength"]); ?></span>
                                        </a>
                                    </li><?php endif; endforeach; endif; ?> 
                    </ul>
                </div>
            </div>
            <div id="tab2" class="weui_tab_bd_item">
                <div class="detail">
                    <h3><?php echo ($videosInfo["name"]); ?></h3>
                    <p class="author">来自：<?php echo ($videosInfo["vres"]); ?></p>
                    <p class="describe">
                        <?php echo ($videosInfo["intro"]); ?>
                    </p>
                    <span class="upload_time">上传时间:<?php echo ($videosInfo["ctime"]); ?></span>
                </div>
                <!--相关推荐-->
                <div class="weui_panel weui_panel_access">
                    <div class="weui_panel_hd">相关推荐</div>
                    <div class="weui_panel_bd">
                        <?php if(is_array($getRelaVideos)): foreach($getRelaVideos as $key=>$vo): ?><a href="<?php echo U('Play/getVideosItem',['vid'=>$vo['id'] ]);?>" class="weui_media_box weui_media_appmsg">
                                <div class="weui_media_hd">
                                    <img class="weui_media_appmsg_thumb" src="/share/<?php echo ($vo["cover"]); ?>" alt="木有图片咋办">
                                </div>
                                <div class="weui_media_bd">
                                    <h4 class="weui_media_title"><?php echo ($vo["name"]); ?></h4>
                                    <p class="weui_media_desc"><?php echo ($vo["intro"]); ?></p>
                                </div>
                            </a><?php endforeach; endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
<script type="text/javascript" src="/share/Public/Mobile/js/zy.media.min.js"charset="utf-8"></script>
<script>
    var vid = <?php echo ($videosInfo["id"]); ?>;
    (function ($){
        $(function(){
            //播放器
            zymedia('video');
        })
        //喜欢
        $("#collect").click(function (){
            var option;
            if( $("#collect").hasClass('liked') ){
                option = 0;
            }else{
                option = 1;
            }
            $.getJSON("<?php echo U('Play/likeVideo');?>",{'option':option,'vid': vid },function (data){
                
                if(data && data.status<0){
                    window.location = "<?php echo U('Passport/index');?>";
                }
            });
            $("#collect").toggleClass('liked');
        });
    })(jQuery)
</script>

    <p class="watermark">E8net-3T小组</p>
</body>
</html>