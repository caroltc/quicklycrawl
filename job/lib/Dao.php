<?php
namespace QuicklyCrawl\Lib;

/**
 * User: congtang
 * Email: congtang@anjuke.com
 * Date: 15-12-23
 * Time: 上午11:46
 */

class Dao
{
    public static $instance;
    public static $cmsInstance;

    /**
     * @return TaskDao
     */
    public static function &getInstance()
    {
        if(empty(self::$instance)){
            self::$instance = new TaskDao();
        }
        return self::$instance;
    }

    /**
     * @return CmsDao
     */
    public static function &getCmsInstance()
    {
        if(empty(self::$cmsInstance)){
            self::$cmsInstance = new CmsDao();
        }
        return self::$cmsInstance;
    }
}