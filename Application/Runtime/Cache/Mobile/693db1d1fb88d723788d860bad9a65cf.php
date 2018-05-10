<?php if (!defined('THINK_PATH')) exit(); if(empty($videosList)): ?><p id="isOver" style="text-align: center;color:#333;padding:10px;background:#eee">没有了</p>
 <?php else: ?>
    <?php if(is_array($videosList)): foreach($videosList as $key=>$vo): ?><a href="<?php echo U('Play/getVideosItem',['vid'=>$vo['id'] ]);?>" class="weui_media_box weui_media_appmsg">
            <div class="weui_media_hd">
                <img class="weui_media_appmsg_thumb" src="/<?php echo ($vo["cover"]); ?>" alt="">
            </div>
            <div class="weui_media_bd">
                <h4 class="weui_media_title"><?php echo ($vo["name"]); ?></h4>
                <p class="weui_media_desc"><?php echo ($vo["intro"]); ?></p>
            </div>
        </a><?php endforeach; endif; endif; ?>