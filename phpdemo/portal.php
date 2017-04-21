<?php
require("config.php");
require("AuthManager.php");

$authManager = new AuthManager($_POST);

if($authManager->validate())
{
	$token = md5(microtime().uniqid());
	$memcache_object = memcache_connect($GLOBALS['memcacheServer'], $GLOBALS['memcachePort']);
	$result = memcache_set($memcache_object, $token, $_POST['uid'],0,30);
	$authManager->redirect("http://myopen.yy.com/weblogindemo/game.php?token=".$token);
}
else
	$authManager->redirect("http://myopen.yy.com/weblogindemo/error.php");

?>
