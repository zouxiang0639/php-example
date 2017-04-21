<?php
require __DIR__ . '/Loader.php';

$a = new \think\Loader();
$a->register();
// 注册错误和异常处理机制
\think\Aa::register();
//\think\Loader::register();



?>