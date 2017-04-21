<?php
require("config.php");
        
$memcache_object = memcache_connect($GLOBALS['memcacheServer'], $GLOBALS['memcachePort']);
$appid = memcache_get($memcache_object, $_GET['token']);

memcache_delete($memcache_object, $_GET['token'],0);

if($appid)
	echo "login success, user id is: ".$appid;
else
	echo "login failed";
?>
