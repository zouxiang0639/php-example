<?php
define('EXT', '.php');
define('DS', DIRECTORY_SEPARATOR);
defined('SYSTEM_PATH') or define('SYSTEM_PATH', __DIR__ . DS);
define('LIB_PATH', SYSTEM_PATH . 'library' . DS);
define('APP_PATH', SYSTEM_PATH . '../app' . DS);
// 载入Loader类
require LIB_PATH . 'Loader.php';
require SYSTEM_PATH . 'helper.php';

// 环境常量
define('IS_CLI', PHP_SAPI == 'cli' ? true : false);
define('IS_WIN', strpos(PHP_OS, 'WIN') !== false);


// 注册自动加载
\system\Loader::register();



//\app\index::index();