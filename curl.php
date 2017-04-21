<?php
//查看源码
if(isset($_GET['source'])) {
    highlight_file(__FILE__);
    exit;
}

function get($home_url,$cookie_file){
    $ch=curl_init($home_url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file); //存储提交后得到的cookie数据
    $contents= curl_exec($ch);
    curl_close($ch);
    return $contents;
}
function post($login_url,$referer,$post_fields,$cookie_file){
    //提交登录表单请求
    $ch=curl_init($login_url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    curl_setopt($ch,CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_REFERER, $referer);    //来路模拟
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    //SSL 报错时使用
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
    curl_setopt($ch,CURLOPT_POSTFIELDS,$post_fields);
    curl_setopt($ch,CURLOPT_COOKIEJAR,$cookie_file); //存储提交后得到的cookie数据
    curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_file); //使用提交后得到的cookie数据做参数
    $a = curl_exec($ch);
    curl_close($ch);
    return $a;
}

$cookie_file = tempnam('/tmp', 'cookie');//dirname(__FILE__) . '/cookie.txt';


  if($_POST){
        $time = time();
      $login_url      = 'https://login.10086.cn/html/login/login.html';
      $post_fields    = "?accountType=01&account={$_POST['account']}&password={$_POST['password']}&pwdType=01&smsPwd={$_POST['smsPwd']}&inputCode=&backUrl=http://shop.10086.cn/i/&rememberMe=0&channelID=12003&protocol=https:&timestamp={$time}";

      //$referer = 'Referer: https://www.zhihu.com/';

      //提交登录表单请求
      $ch=curl_init($login_url);
      $a=get($home_url.$post_fields,$cookie_file);

      //登录成功后，获取首页数据
      $ch=curl_init($home_url);
      curl_setopt($ch,CURLOPT_HEADER,0);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false );    //SSL 报错时使用
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    //SSL 报错时使用
      curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch,CURLOPT_COOKIEFILE,$cookie_file); //使用提交后得到的cookie数据做参数
      $contents=curl_exec($ch);
      curl_close($ch);

      echo $contents;
      exit;
  }else{
      //访问首页，存储cookie数据

      $home_url = 'https://login.10086.cn/html/login/login.html';

   get($home_url,$cookie_file);

  }

?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP cURL 模拟知乎登录</title>
    <meta charset="utf-8">
</head>
<body>
<form method="post">
    <div>知乎登录邮箱/手机号：<input type="text" name="account"></div>
    <div>知乎登录密码：<input type="text" name="password"></div>
    <input name="smsPwd" class="reg_input" style="width:80px" maxlength="6" type="text">
    <a class="login_a hide"  onclick="sendSmsPwd()" style="display: inline;">点击获取</a>
    <div><input type="submit" value="提交"></div>
</form>
<p>
    <a href="?source" target="_blank">查看PHP源码</a>
<p>
    更多模拟登录与采集内容，请参考：《<a href="http://www.zjmainstay.cn/php-curl">PHP cURL实现模拟登录与采集使用方法详解</a>》
</p>
</p>
</body>
</html>