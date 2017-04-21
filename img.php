<?php
$qq = 542506;
$email= '444@qq.com';
$font_file = '/font/msyh.ttf';
header("Content-type: image/png");
$im = imagecreate(200,60);
$bg = imagecolorallocate($im,255,255,255);
$color = imagecolorallocate($im, 0, 0, 255);
imagestring($im, 5, 0, 0, $qq, $color);
imagefttext($im, 13, 0, 0, 35, $color, $font_file,mb_convert_encoding('测试','html-entities','UTF-8'));
imagestring($im, 20, 0, 40, $email, $color);
imagepng($im);
?>