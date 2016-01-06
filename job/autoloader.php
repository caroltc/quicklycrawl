<?php
namespace QuicklyCrawl;
/**
 * Created by PhpStorm.
 * User: congtang
 * Date: 2016/1/5
 * Time: 19:55
 * Email: 312493732@qq.com
 */
class Autoloader
{
    const NAMESPACE_PREFIX = 'QuicklyCrawl\\';
    /**
     * 注册自动载入函数
     */
    public static function register()
    {
        spl_autoload_register(array(new self, 'autoload'));
    }

    /**
     * 自动加载
     * @param $className
     */
    public static function autoload($className)
    {
        $namespacePrefixStrlen = strlen(self::NAMESPACE_PREFIX);
        if(strncmp(self::NAMESPACE_PREFIX, $className, $namespacePrefixStrlen) === 0){
            $className = strtolower($className);
            $filePath = str_replace('\\', DIRECTORY_SEPARATOR, substr($className, $namespacePrefixStrlen));
            $filePath = realpath(__DIR__ . (empty($filePath) ? '' : DIRECTORY_SEPARATOR) . $filePath . '.php');
            if(file_exists($filePath)){
                require_once $filePath;
            }else{
                echo $filePath;
            }
        }
    }
}