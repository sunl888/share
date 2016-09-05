<?php

/**
 *
 * @author 孙龙
 */

/**
 * 原格式输出
 */
function p(){
    $args = func_get_args();
    echo '<pre>';
    foreach($args as $v){
        if(empty($v)){
            var_dump($v);
        }else{
            print_r($v);
        }
        echo "\n\n";
    }
    echo '</pre>';
    die('--the end--');
}

/**
 * 视频秒转成天时分秒方法
 * return $arr
 */
function FormateTime($seconds){
    $seconds = (int)$seconds;
    $format_time = gmstrftime('%H:%M:%S', $seconds);
	//p($format_time);
    return $format_time;
}
/**
 * 格式化字节方法
 * $dec表示小数点的位数 默认2位
 * return $string
 */
function FormatByte($size,$dec=2)
{
    $a = array("B","KB","MB","GB","TB","PB","EB","ZB","YB");
    $pos = 0;
    while ($size >= 1024)   
    {
        $size /= 1024;
        $pos++;
    }
    return round($size,$dec)." ".$a[$pos];
}


/**
 * 格式化时间戳方法
 */
function Formatdate($date,$field=''){
    if(is_array($date)){
        $date[$field] = date("Y-m-d",$date[$field]);
    }else{
        $date = date("Y-m-d",$date);
    }
    
    return $date;
}

/**
 * 格式化时间戳方法
 */
function time2date($time){
    return date("Y-m-d",$time);
}
/**
 * 获取文件 md5 webUploader
 * @param type $file
 * @return type
 */
function mymd5( $file ) {
    $fragment = 65536;
    $rh = fopen($file, 'rb');
    $size = filesize($file);
    $part1 = fread( $rh, $fragment );
    fseek($rh, $size-$fragment);
    $part2 = fread( $rh, $fragment);
    fclose($rh);
    return md5( $part1.$part2 );
}

/**
 * 获取文件扩展名
 */
function exte($file_name) 
{ 
    $extend =explode("." , $file_name); 
    $va=count($extend)-1; 
    return $extend[$va]; 
} 

/**
 * 递归创建文件夹
 * @param string
 */
function createFolder($path)
 {
  if (!file_exists($path))
  {
   createFolder(dirname($path));
   mkdir($path, 0777);
  }
 }
 

//获得视频文件的总长度时间和创建时间 
function getVideoTime($file){ 
    $vtime =shell_exec("ffmpeg -i ".$file." 2>&1 | grep 'Duration' | cut -d ' ' -f 4 | sed s/,//");//总长度 
    $ctime = date("Y-m-d H:i:s",filectime($file));//创建时间 
    return array('vtime'=>$vtime, 
    'ctime'=>$ctime 
    ); 
} 
//获得视频文件的缩略图 
function getVideoCover($file,$time) { 
    if(empty($time))
        $time = '1';//默认截取第一秒第一帧 
    $strlen = strlen($file); 
    $videoCover = substr($file,0,$strlen-4); 
    $videoCoverName = $videoCover.'.jpg';//缩略图命名 
    exec("ffmpeg -i ".$file." -y -f mjpeg -ss ".$time." -t 0.001 -s 320x240 ".$videoCoverName."",$out,$status); 
    if($status == 0)
        return $videoCoverName; 
    elseif ($status == 1)
        return FALSE; 
}

/**
 * safetyHtml函数用于过滤不安全的html标签，输出安全的html
 * @param string $text 待过滤的字符串
 * @param string $type 保留的标签格式
 * @return string 处理后内容
 */
function safetyHtml($text, $type = 'html'){
    //将换行符转换成<br />
    $text = nl2br($text);
    // 无标签格式
    $text_tags  = '';
    //只保留链接
    $link_tags  = '<a>';
    //只保留图片
    $image_tags = '<img>';
    //只存在字体样式
    $font_tags  = '<i><b><u><s><em><strong><font><big><small><sup><sub><bdo><h1><h2><h3><h4><h5><h6>';
    //标题摘要基本格式
    $base_tags  = $font_tags.'<p><br><hr><a><img><map><area><pre><code><q><blockquote><acronym><cite><ins><del><center><strike>';
    //兼容Form格式
    $form_tags  = $base_tags.'<form><input><textarea><button><select><optgroup><option><label><fieldset><legend>';
    //内容等允许HTML的格式
    $html_tags  = $base_tags.'<meta><ul><ol><li><dl><dd><dt><table><caption><td><th><tr><thead><tbody><tfoot><col><colgroup><div><span><object><embed><param>';
    //专题等全HTML格式
    $all_tags   = $form_tags.$html_tags.'<!DOCTYPE><html><head><title><body><base><basefont><script><noscript><applet><object><param><style><frame><frameset><noframes><iframe>';
    //过滤标签
    $text = real_strip_tags($text, ${$type.'_tags'});
    // 过滤攻击代码
    if($type != 'all') {
        // 过滤危险的属性，如：过滤on事件lang js
        while(preg_match('/(<[^><]+)(allowscriptaccess|ondblclick|onclick|onload|onerror|unload|onmouseover|onmouseup|onmouseout|onmousedown|onkeydown|onkeypress|onkeyup|onblur|onchange|onfocus|action|background|codebase|dynsrc|lowsrc)([^><]*)/i',$text,$mat)){
            $text = str_ireplace($mat[0], $mat[1].$mat[3], $text);
        }
        while(preg_match('/(<[^><]+)(window\.|javascript:|js:|about:|file:|document\.|vbs:|cookie)([^><]*)/i',$text,$mat)){
            $text = str_ireplace($mat[0], $mat[1].$mat[3], $text);
        }
    }
    return $text;
}
function real_strip_tags($str, $allowable_tags="") {
    $str = html_entity_decode($str,ENT_QUOTES,'UTF-8');
    return strip_tags($str, $allowable_tags);
}
