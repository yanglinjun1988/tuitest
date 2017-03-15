<?php
header('Content-type: text/html; charset=utf-8');
error_reporting(0);
$config = array();
session_start();
#将数据库链接配置文件存放到数组中
$Dconfig = array_merge(require dirname(__FILE__) . '/config.php',$config);
require dirname(__FILE__) . '/wz.class.php';
?>