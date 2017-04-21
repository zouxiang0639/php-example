<?php
namespace system;

class Loader
{
    protected static $instance = [];
    // 类名映射
    protected static $map = [];

    // 命名空间别名
    protected static $namespaceAlias = [];

    // PSR-4
    private static $prefixLengthsPsr4 = [];
    private static $prefixDirsPsr4    = [];
    private static $fallbackDirsPsr4  = [];

    // PSR-0
    private static $prefixesPsr0     = [];
    private static $fallbackDirsPsr0 = [];

    // 自动加载的文件
    private static $autoloadFiles = [];
    // 自动加载
    public static function autoload($class)
    {

        // 检测命名空间别名
        if (!empty(self::$namespaceAlias)) {
            $namespace = dirname($class);
            if (isset(self::$namespaceAlias[$namespace])) {
                $original = self::$namespaceAlias[$namespace] . '\\' . basename($class);
                if (class_exists($original)) {
                    return class_alias($original, $class, false);
                }
            }
        }

        if ($file = self::findFile($class)) {

            // Win环境严格区分大小写
            if (IS_WIN && pathinfo($file, PATHINFO_FILENAME) != pathinfo(realpath($file), PATHINFO_FILENAME)) {
                return false;
            }

            include $file;
            //__include_file($file);
            return true;
        }
    }

    public static function register($autoload = '')
    {

        // 注册系统自动加载
        spl_autoload_register($autoload ?: 'system\\Loader::autoload', true, true);


        // 注册命名空间定义
        self::addNamespace([
            'system'    => LIB_PATH . DS,
            'app'    => APP_PATH . DS
        ]);

     /*   // 加载类库映射文件
        if (is_file(RUNTIME_PATH . 'classmap' . EXT)) {
            self::addClassMap(__include_file(RUNTIME_PATH . 'classmap' . EXT));
        }

        // Composer自动加载支持
        if (is_dir(VENDOR_PATH . 'composer')) {
            self::registerComposerLoader();
        }*/

        // 自动加载extend目录
       // self::$fallbackDirsPsr4[] = rtrim(EXTEND_PATH, DS);
    }

    // 注册命名空间
    public static function addNamespace($namespace, $path = '')
    {

        if (is_array($namespace)) {
            foreach ($namespace as $prefix => $paths) {

                self::addPsr4($prefix . '\\', rtrim($paths, DS), true);
            }
        } else {
            self::addPsr4($namespace . '\\', rtrim($path, DS), true);
        }
    }

    // 添加Psr4空间
    private static function addPsr4($prefix, $paths, $prepend = false)
    {

        if (!$prefix) {
            // Register directories for the root namespace.
            if ($prepend) {
                self::$fallbackDirsPsr4 = array_merge(
                    (array) $paths,
                    self::$fallbackDirsPsr4
                );
            } else {
                self::$fallbackDirsPsr4 = array_merge(
                    self::$fallbackDirsPsr4,
                    (array) $paths
                );
            }

        } elseif (!isset(self::$prefixDirsPsr4[$prefix])) {

            // Register directories for a new namespace.
            $length = strlen($prefix);

            if ('\\' !== $prefix[$length - 1]) {
                throw new \InvalidArgumentException("A non-empty PSR-4 prefix must end with a namespace separator.");
            }
            self::$prefixLengthsPsr4[$prefix[0]][$prefix] = $length;

            self::$prefixDirsPsr4[$prefix]                = (array) $paths;
        } elseif ($prepend) {


            // Prepend directories for an already registered namespace.
            self::$prefixDirsPsr4[$prefix] = array_merge(
                (array) $paths,
                self::$prefixDirsPsr4[$prefix]
            );
        } else {
            // Append directories for an already registered namespace.
            self::$prefixDirsPsr4[$prefix] = array_merge(
                self::$prefixDirsPsr4[$prefix],
                (array) $paths
            );
        }
    }

    /**
     * 查找文件
     * @param $class
     * @return bool
     */
    private static function findFile($class)
    {

        if (!empty(self::$map[$class])) {
            // 类库映射
            return self::$map[$class];
        }

        // 查找 PSR-4
        $logicalPathPsr4 = strtr($class, '\\', DS) . EXT;

        $first = $class[0];

        if (isset(self::$prefixLengthsPsr4[$first])) {

            foreach (self::$prefixLengthsPsr4[$first] as $prefix => $length) {
                if (0 === strpos($class, $prefix)) {
                    foreach (self::$prefixDirsPsr4[$prefix] as $dir) {
                        if (is_file($file = $dir . DS . substr($logicalPathPsr4, $length))) {

                            return $file;
                        }
                    }
                }
            }
        }

        // 查找 PSR-4 fallback dirs
        foreach (self::$fallbackDirsPsr4 as $dir) {
            if (is_file($file = $dir . DS . $logicalPathPsr4)) {
                return $file;
            }
        }

        // 查找 PSR-0
        if (false !== $pos = strrpos($class, '\\')) {
            // namespaced class name
            $logicalPathPsr0 = substr($logicalPathPsr4, 0, $pos + 1)
                . strtr(substr($logicalPathPsr4, $pos + 1), '_', DS);
        } else {
            // PEAR-like class name
            $logicalPathPsr0 = strtr($class, '_', DS) . EXT;
        }

        if (isset(self::$prefixesPsr0[$first])) {
            foreach (self::$prefixesPsr0[$first] as $prefix => $dirs) {
                if (0 === strpos($class, $prefix)) {
                    foreach ($dirs as $dir) {
                        if (is_file($file = $dir . DS . $logicalPathPsr0)) {
                            return $file;
                        }
                    }
                }
            }
        }

        // 查找 PSR-0 fallback dirs
        foreach (self::$fallbackDirsPsr0 as $dir) {
            if (is_file($file = $dir . DS . $logicalPathPsr0)) {
                return $file;
            }
        }

        return self::$map[$class] = false;
    }

    /**
     * 远程调用模块的操作方法 参数格式 [模块/控制器/]操作
     * @param string       $url          调用地址
     * @param string|array $vars         调用参数 支持字符串和数组
     * @param string       $layer        要调用的控制层名称
     * @param bool         $appendSuffix 是否添加类名后缀
     * @return mixed
     */
    public static function action($url, $vars = [], $layer = 'controller', $appendSuffix = false)
    {
        $info   = pathinfo($url);
        $action = $info['basename'];
        $module = '.' != $info['dirname'] ? $info['dirname'] : Request::instance()->controller();
        $class  = self::controller($module, $layer, $appendSuffix);
        if ($class) {
            if (is_scalar($vars)) {
                if (strpos($vars, '=')) {
                    parse_str($vars, $vars);
                } else {
                    $vars = [$vars];
                }
            }
            return App::invokeMethod([$class, $action . Config::get('action_suffix')], $vars);
        }
    }

    public static function controller(Request $request)
    {
        $dispatch = $request->dispatch();
        $action = $dispatch['action'];
        unset($dispatch['action']);
        $controller = implode('\\', $dispatch);
        $controller = '\\app\\'.$controller;
        if(is_object(new $controller())){
          return  (new $controller())->$action();
        }
    }
}


/**
 * 作用范围隔离
 *
 * @param $file
 * @return mixed
 */
function __include_file($file)
{

    return include $file;
}
function __require_file($file)
{
    return require $file;
}
