<?php
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'

define('CP_PATH',dirname(__FILE__).'/../include/');//注意目录后面加“/”
define('CONFIGDIR',dirname(__FILE__).'/../conf/config.php');
define('ROOTDIR', str_replace("\\",'/',substr(dirname(__FILE__), 0, strrpos(dirname(__FILE__), DIRECTORY_SEPARATOR))));
require(CONFIGDIR);//加载配置
require(CP_PATH.'core/cpApp.class.php');//加载应用控制类
$config['DB_CACHE_ON']=false;//后台不生成数据库缓存
$config['HTML_CACHE_ON']=false;//后台不生成静态页面
$app=new cpApp($config);//实例化单一入口应用控制类
//执行项目
$app->run();

?>