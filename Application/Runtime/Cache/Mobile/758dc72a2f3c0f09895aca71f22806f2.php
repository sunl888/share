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
    <!--header-->
<header class="topBar">
    <a href="<?php echo U('Index/index');?>">
        <i class="iconfont icon-jiantou1"></i>
    </a>
    <h2><?php echo ($videosCateName); ?></h2>
</header>
<section>
    <div class="weui_panel weui_panel_access">
        <div class="weui_panel_bd" id="listItem">
            <!--ajax获取数据-->
        </div>
    </div>
</section>

<script>
    $(function (){
        var listUrl = "<?php echo ($listUrl); ?>";
        
        var listItem = $("#listItem");
        var flag = "<?php echo ($flag); ?>";
        
        var ajax_getting = false;
        var offset = 0;
        var limit = 10;
        var timer=null;
        $.get(listUrl,{'limit':limit,'offset':offset,'flag':flag},function (data){
            
            listItem.append(data);
            offset+=limit;
        });
        var isOver = false;
        $(window).scroll(function() {
            if(isOver){
                return ;
            }
            if(timer)
                clearTimeout(timer);
          timer = setTimeout(function() {
            var scrollTop = $(document.body).scrollTop();　　
            var scrollHeight = $('body').height();　　
            var windowHeight = innerHeight;
            var scrollWhole = Math.max(scrollHeight - scrollTop - windowHeight);
            if (scrollWhole < 100) {
              if (ajax_getting) {
                return false;
              } else {
                ajax_getting = true;
              }
              $('html,body').scrollTop($(window).height() + $(document).height());
             
              $.ajax({
                url: listUrl,
                type: 'GET',
                data:{'limit':limit,'offset':offset,'flag':flag},
                success: function (data) {
                    if($(data).attr('id') == 'isOver'){
                        isOver = true;
                    }
                    listItem.append(data);
                    ajax_getting = false;
                    offset += limit;
                }
              });
            };
          }, 200);
        });
        
    });
</script>
    <p class="watermark">E8net-3T小组</p>
</body>
</html>