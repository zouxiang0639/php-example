<?php
namespace system;

class App
{
    static $request;
    public static function run(Request $request = null)
    {
        $pathInfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
        $pathInfo = explode('/', $pathInfo);
        $dispatch = [
            'module'        => isset($pathInfo[1]) ? $pathInfo[1] : 'index',
            'controller'        => isset($pathInfo[2]) ? $pathInfo[2] : 'Index',
            'action'        => isset($pathInfo[3]) ? $pathInfo[3] : 'index',
        ];
        $request = Request::instance(array_merge($dispatch, ['dispatch' => $dispatch]));
        Loader::controller($request);
    }
}