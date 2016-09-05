<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +---------------------------------------------------------------------
// 应用入口文件
// 
// 项目开始日期: 2016/7/15
// 
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);
// 定义应用目录
define('APP_PATH','./Application/');

//判断访客是手机端还是电脑端访问////
 function is_mobile(){  
    $user_agent = $_SERVER['HTTP_USER_AGENT'];  
    //遍历所有的手机型号
    $mobile_agents = Array(
        "240x320","acer","acoon","acs-","abacho",
        "ahong","airness","alcatel","amoi","android",
        "anywhereyougo.com","applewebkit/525","applewebkit/532",
        "asus","audio","au-mic","avantogo","becker","benq",
        "bilbo","bird","blackberry","blazer","bleu","cdm-",
        "compal","coolpad","danger","dbtel","dopod","elaine",
        "eric","etouch","fly ","fly_","fly-","go.web","goodaccess",
        "gradiente","grundig","haier","hedy","hitachi","htc","huawei",
        "hutchison","inno","ipad","ipaq","ipod","jbrowser","kddi","kgt",
        "kwc","lenovo","lg ","lg2","lg3","lg4","lg5","lg7","lg8","lg9",
        "lg-","lge-","lge9","longcos","maemo","mercator","meridian",
        "micromax","midp","mini","mitsu","mmm","mmp","mobi","mot-",
        "moto","nec-","netfront","newgen","nexian","nf-browser",
        "nintendo","nitro","nokia","nook","novarra","obigo","palm",
        "panasonic","pantech","philips","phone","pg-","playstation",
        "pocket","pt-","qc-","qtek","rover","sagem","sama","samu","sanyo",
        "samsung","sch-","scooter","sec-","sendo","sgh-","sharp","siemens",
        "sie-","softbank","sony","spice","sprint","spv","symbian","tablet",
        "talkabout","tcl-","teleca","telit","tianyu","tim-","toshiba","tsm",
        "up.browser","utec","utstar","verykool","virgin","vk-","voda","voxtel",
        "vx","wap","wellco","wig browser","wii","windows ce","wireless","xda","xde","zte"
    );  
    $is_mobile = false;  
    foreach ($mobile_agents as $device) {//这里把值遍历一遍，用于查找是否有上述字符串出现过  
       if (stristr($user_agent, $device)) { //stristr 查找访客端信息是否在上述数组中，不存在即为PC端。  
            $is_mobile = true;  
            break;  
        }  
    }  
    return $is_mobile;  
}
//绑定入口模块
if(is_mobile()){ 
    define('BIND_MODULE', 'Mobile');     
}else{  
    define('BIND_MODULE', 'Home');           
}
////end/////

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单