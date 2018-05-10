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
    <html>
<head>
    <title>登录</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="/Public/Mobile/css/weui.min.css">
    <link rel="stylesheet" href="/Public/Mobile/css/jquery-weui.min.css">
    <link rel="stylesheet" href="/Public/Mobile/css/comm.css">
</head>
<body>
<!--header-->
<header class="topBar">
    <a href="<?php echo U('Index/index');?>">
        <i class="iconfont icon-jiantou1"></i>
        <h2>登录</h2>
    </a>
    <a><h2 class="register" id="register">注册</h2></a>
</header>
<section class="login">
    <form method="POST" action="<?php echo U('Passport/doLogin');?>">
        <input type="text" name="username" placeholder="请输入账号">
        <input type="password" name="password" placeholder="请输入密码">
        <input type="submit" value="登录">
    </form>
</section>


<script type="text/javascript" src="/Public/Mobile/js/jquery-2.1.4.js"charset="utf-8"></script>
<script type="text/javascript" src="/Public/Mobile/js/jquery-weui.min.js"charset="utf-8"></script>
<script>
    $(function(){
        $("#register").click(function(){
            $.alert("注册请联系E8网络工作室", "提示", function() {
                $.closeModal();
            });
        })
    })
</script>
</body>
</html>
    <p class="watermark">E8net-3T小组</p>
</body>
</html>