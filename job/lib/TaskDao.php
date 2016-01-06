<?php
namespace QuicklyCrawl\Lib;

/**
 * User: congtang
 * Email: congtang@anjuke.com
 * Date: 15-12-23
 * Time: 上午11:46
 */

class TaskDao extends BaseDao
{

    /**
     *
     * @param array $config
     * array('host' => , 'db' => , 'user' => , 'password' => )
     */
    function setDaoInfo()
    {
        $daoinfo = array();
        $daoinfo['host'] = 'localhost';
        $daoinfo['db'] = 'quickcrawl';
        $daoinfo['user'] = 'root';
        $daoinfo['password'] = 'root';
        return $daoinfo;
    }
}