<?php 
	/**
	* 数据库配置信息
	*/
	
	$mysql_server = '127.0.0.1';
	$mysql_username = 'root';
	$mysql_password = 'coder4me';
	$mysql_database = 'dd';
	/**
	*连接数据库
	*/	
	$conn = mysql_connect($mysql_server , $mysql_username , $mysql_password);
	if(!$conn){
		die('数据库连接失败');
	}
	
	/**
	*查询有问题的视频
	*/
	$sql = "select * from videos_item where timelength='' ";
	$del = "delete from videos_item where timelength=''";
	$del_result = mysql_db_query($mysql_database , $sql , $conn);
	if(!$del_result){
		die('删除数据出现错误.');
	}
	//查询数据返回结果集
	$result = mysql_db_query($mysql_database , $sql , $conn);
	//mysql_fetch_array($result , MYSQL_ASSOC | MYSQL_NUM) 表示从结果集中取得一行作为关联数组，或数字数组
	if( $arr = mysql_fetch_array($result , MYSQL_ASSOC) ){
		//删除错误数据
		unlink($arr['addr']);
	}
?>
