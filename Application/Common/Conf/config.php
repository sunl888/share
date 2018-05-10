<?php
return array(
	//'配置项'=>'配置值'

	// 数据库相关配置
	'DB_CHARSET' => 'utf8', // 数据库字符编码
	'DB_TYPE' => 'mysql', // 数据库类型
	'DB_HOST' => 'mysql', // 主机名称
    'DB_NAME' => 'share',
	'DB_USER' => 'share', // 数据库管理员用户名
	'DB_PWD' => 'share', // 数据库管理员密码
	'DB_PREFIX' => '', // 数据库前缀
	//'SHOW_PAGE_TRACE' =>true, // 显示页面Trace信息
    //todo 这里的urlmodel改成了2  pathinfo
	'URL_MODEL' => 2
);
