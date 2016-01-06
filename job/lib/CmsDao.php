<?php
namespace QuicklyCrawl\Lib;

/**
 * User: congtang
 * Email: congtang@anjuke.com
 * Date: 15-12-23
 * Time: 上午11:46
 */

class CmsDao extends BaseDao
{

    /**
     *
     * @param array $config
     * array('host' => , 'db' => , 'user' => , 'password' => )
     */
    function setDaoInfo()
    {
        $daoinfo = array();
        $daoinfo['host'] = '';
        $daoinfo['db'] = 'caroltc_cms';
        $daoinfo['user'] = 'caroltc';
        $daoinfo['password'] = 'admin';
        return $daoinfo;
    }
}