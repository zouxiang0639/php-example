<?php
print_r(date('m/d/y H:i:s',time()));die;
$test = "cal";   //ls是linux下的查目录，文件的命令
$output = shell_exec('cal');    //执行命令
print_r($output);
?>