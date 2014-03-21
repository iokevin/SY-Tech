<?php
header('Content-Type:text/html; charset=utf-8');
date_default_timezone_set('Asia/Shanghai');//'Asia/Shanghai'

define('CP_PATH',dirname(__FILE__).'/include/');//注意目录后面加“/”

require(dirname(__FILE__).'/conf/config.php');//加载配置
require(CP_PATH.'core/cpApp.class.php');//加载应用控制类

$app=new cpApp($config);//实例化单一入口应用控制类
//执行项目
$app->run();

?>