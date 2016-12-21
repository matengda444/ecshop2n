<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE'               =>  'mysql',     // 数据库类型
    'DB_HOST'               =>  '127.0.0.1', // 服务器地址
    'DB_NAME'               =>  'e2',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'e2_',    // 数据库表前缀
	'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
    // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式
    'URL_PATHINFO_DEPR'     =>  '-',	// PATHINFO模式下，各参数之间的分割符
    'UPLOAD_ROOT_PATH'      =>  './Public/Uploads/',    //上传文件根路径   (.)基于入口文件位置
    'UPLOAD_MAX_FILESIZE'   =>  '10M',   //上传文件最大值
    'UPLOAD_ALLOW_EXT'      =>  array('jpeg', 'jpg', 'png', 'gif', 'bmp'),    //上传文件类型
);
