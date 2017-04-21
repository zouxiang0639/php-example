<?php
$time = strtotime('2017-3-1 00:00:00');
$a = strtotime('2017-4-4 23:59:59');
do{
    print_r(date('Y-m-d', $time));echo '<br>';
    $time = strtotime('+1 day',$time);
} while ($time < $a);