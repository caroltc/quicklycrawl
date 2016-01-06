<?php
namespace QuicklyCrawl\Lib;

/**
 * Job游标处理
 * User: congtang
 * Email: congtang@anjuke.com
 * Date: 15-12-23
 * Time: 上午11:30
 */

class JobCursor
{
    const TABLE = 'job_runed_cursor';

    public static $instance;

    public static function &getInstance()
    {
        if(empty(self::$instance)){
            self::$instance = new JobCursor();
        }
        return self::$instance;
    }

    /**
     * 获取游标
     * @param $classname
     * @param $flag
     * @return array|bool
     */
    public function getCursor($classname, $flag)
    {
        $rs = false;
        $where = array('classname' => $classname, 'identify_flag' => $flag);
        $data = Dao::getInstance()->findRow(self::TABLE, $where);
        if(!empty($data) && isset($data['value'])){
            $rs = $data['value'];
        }
        return $rs;
    }

    /**
     * 设置游标
     * @param $classname
     * @param $flag
     * @param $value
     * @return bool
     */
    public function setCursor($classname, $flag, $value)
    {
        $data = array('classname' => $classname, 'identify_flag' => $flag, 'value' => $value);
        $st = Dao::getInstance()->replace(self::TABLE, $data);
        return $st;
    }
}