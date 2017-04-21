<?php

function s_sym($num)
{
    $desc = 0;
    $asc = $num;
    while($num%10 >0){
        $desc = ($desc * 10) + ($num % 10);
        $num=$num/10;
    }

    if($asc == $desc)
    {
        return 1;
    }else{
        return 0;
    }
}


print_r(s_sym(22));