<?php
namespace QuicklyCrawl\Lib;

/**
 * User: congtang
 * Email: congtang@anjuke.com
 * Date: 15-12-23
 * Time: 上午11:46
 */

abstract class BaseDao
{

    public $host = '';
    public $db = '';
    public $user = '';
    public $password = '';

    protected $limit = 100;
    protected $pdo;

    /**
     * 设置配置
     * @return array
     * array('host' => , 'db' => , 'user' => , 'password' => )
     */
    abstract function setDaoInfo();

    public function __construct()
    {
        $configs = $this->setDaoInfo();
        $this->host = $configs['host'];
        $this->db = $configs['db'];
        $this->user = $configs['user'];
        $this->password = $configs['password'];
        $this->pdo = new \PDO('mysql:host=' . $this->host . ';dbname=' . $this->db, $this->user, $this->password, array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8';"));
    }

    /**
     * @param $table
     * @param array $where
     * @param string $fields
     * @param $order
     * @param int $limit
     * @param int $offset
     * @return array
     */
    public function find($table, $where = array(), $fields = '*', $order, $limit = self::LIMIT, $offset = 0)
    {
        if(is_array($where)){
            $where_condition = array();
            foreach($where as $field => $value){
                if(!is_numeric($value)){
                    $value = '"' . $value . '"';
                }
                $where_condition[] = '`' . $field . '`' . '=' . $value;
            }
            $where = implode(' and ', $where_condition);
        }
        $sql = "select {$fields} from `{$table}` where {$where} order by {$order} limit {$offset},{$limit}";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode( \PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

    /**
     *
     * @param $table
     * @param array $where
     * @return bool|array
     */
    public function findRow($table, $where, $fields = '*')
    {
        if(is_array($where)){
            $where_condition = array();
            foreach($where as $field => $value){
                if(!is_numeric($value)){
                    $value = '"' . $value . '"';
                }
                $where_condition[] = '`' . $field . '`' . '=' . $value;
            }
            $where = implode(' and ', $where_condition);
        }
        $sql = "select {$fields} from `{$table}` where {$where} limit 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result;
    }

    /**
     * @param $table
     * @param array $data
     * @return bool
     */
    public function replace($table, array $data)
    {
        $field_arrays = array_keys($data);
        foreach($field_arrays as $key => $val){
            $field_arrays[$key] = '`' . $val . '`';
        }
        $value_arrays = array_values($data);
        foreach($value_arrays as $key => $val){
            if(!is_numeric($val)){
                $value_arrays[$key] = '"' . $val . '"';
            }
        }
        $fields = implode(',', $field_arrays);
        $values = implode(',', $value_arrays);
        $sql = "replace into `{$table}`({$fields}) values({$values})";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * @param $table
     * @param array $data
     * @return bool
     */
    public function add($table, array $data)
    {
        $field_arrays = array_keys($data);
        foreach($field_arrays as $key => $val){
            $field_arrays[$key] = '`' . $val . '`';
        }
        $value_arrays = array_values($data);
        foreach($value_arrays as $key => $val){
            if(!is_numeric($val)){
                $value_arrays[$key] = '"' . $val . '"';
            }
        }
        $fields = implode(',', $field_arrays);
        $values = implode(',', $value_arrays);
        $sql = "insert into `{$table}`({$fields}) values({$values})";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * @param $table
     * @param $where
     * @param array $data
     * @return bool
     */
    public function update($table, $where, array $data)
    {
        $update_fields = array();
        foreach($data as $field => $value){
            if(!is_numeric($value)){
                $value = '"' . $value . '"';
            }
            $update_fields[] = $field . '=' . $value;
        }
        $updates = implode(',', $update_fields);
        $sql = "UPDATE `{$table}` SET {$updates} WHERE {$where}";
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * @param $sql
     * @param array $params
     * @return bool
     */
    public function execSql($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $result = $stmt->execute($params);
        return $result;
    }

    /**
     * @param $sql
     * @param array $params
     * @return array
     */
    public function query($sql, $params = array())
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $stmt->setFetchMode( \PDO::FETCH_ASSOC);
        $result = $stmt->fetchAll();
        return $result;
    }

}