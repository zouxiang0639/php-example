<?php

/**
 * 浏览器友好的变量输出
 * @param mixed         $var 变量
 * @param boolean       $echo 是否输出 默认为true 如果为false 则返回输出字符串
 * @param string        $label 标签 默认为空
 * @param integer       $flags htmlspecialchars flags
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $flags = ENT_SUBSTITUTE)
{
    $label = (null === $label) ? '' : rtrim($label) . ':';
    ob_start();
    var_dump($var);
    $output = ob_get_clean();
    $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
    if (IS_CLI) {
        $output = PHP_EOL . $label . $output . PHP_EOL;
    } else {
        if (!extension_loaded('xdebug')) {
            $output = htmlspecialchars($output, $flags);
        }
        $output = '<pre>' . $label . $output . '</pre>';
    }
    if ($echo) {
        echo($output);
        return;
    } else {
        return $output;
    }
}

function url($url, $options = null)
{
    $get = function($options, $i = 1){
        $get = '';
        if($options != null){
            foreach($options as $key => $value){
                $operational = $i == 1 ? '?' : '#';
                $get .= "{$operational}{$key}={$value}";
                $i++;
            }
        }
        return $get;
    };

    $urlPach = array_reverse(explode('/',$url));
    $request = \system\Request::instance();

    $url = $request->dispatch();
    $url['module']  = isset($urlPach[2]) ? $urlPach[2] : $url['module'] ;
    $url['controller']  = isset($urlPach[1]) ? $urlPach[1] : $url['controller'] ;
    $url['action']  = isset($urlPach[0]) ? $urlPach[0] : $url['action'] ;
    $http = $request->server('SCRIPT_NAME');
    return "{$http}/{$url['module']}/{$url['controller']}/{$url['action']}".$get($options);

}