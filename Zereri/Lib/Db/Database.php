<?php
namespace Zereri\Lib\Db;

use Zereri\Lib\Register;

class Database
{

    /**数据库pdo连接实例
     *
     * @var \PDO
     */
    protected $conn;


    /**数据库操作
     *
     * @var string
     */
    protected $crud;


    /**从库索引
     *
     * @var int
     */
    protected $slave_db_index;


    /**预处理实例
     *
     * @var object
     */
    protected $instance;


    /**是否是插入模式
     *
     * @var bool
     */
    protected $is_insert_mode;


    /**数据插入后返回的id
     *
     * @var array
     */
    protected $insert_id;


    /**正确执行sql语句的次数
     *
     * @var int
     */
    protected $correct_query_res;


    /**数据库的配置
     *
     * @var array
     */
    protected $db_config;


    public function __construct($crud = "")
    {
        $this->crud = $crud;
        $this->db_config =& config("database");
        $this->conn = $this->getConnection();
    }


    protected function getConnection()
    {
        if ($this->crud === 'select' && $this->hasSlaveDb() && $this->getSalveDbNum()) {
            return Register::get("database_slave") ?: $this->connectDBAndAddToRegister("slave");
        }

        return Register::get("database_master") ?: $this->connectDBAndAddToRegister("master");
    }


    protected function hasSlaveDb()
    {
        return isset($this->db_config['slave']);
    }


    protected function getSalveDbNum()
    {
        switch ($count = count($this->db_config['slave'])) {
            //no break at all
            case 0:
                return false;
            case 1:
                $this->slave_db_index = 0;

                return true;
            default:
                $this->slave_db_index = time() % $count;

                return true;
        }
    }


    /**注册数据库连接并且返回
     *
     * @param string $host 连接的主或从数据库(slave or master)
     *
     * @return \PDO
     */
    protected function connectDBAndAddToRegister($host)
    {
        $conn = $this->connectDB($host);
        Register::set("database_" . $host, $conn);

        return $conn;
    }


    protected function connectDB($host)
    {
        try {
            switch ($host) {
                //no break at all
                case "master":
                    return new \PDO($this->db_config['master']['drive'] . ":host=" . $this->db_config['master']['host'] . ";dbname=" . $this->db_config['master']['dbname'] . ";charset=" . $this->db_config['master']['charset'], $this->db_config['master']['user'], $this->db_config['master']['pwd']);
                case "slave":
                    return new \PDO($this->db_config['slave'][ $this->slave_db_index ]['drive'] . ":host=" . $this->db_config['slave'][ $this->slave_db_index ]['host'] . ";dbname=" . $this->db_config['slave'][ $this->slave_db_index ]['dbname'] . ";charset=" . $this->db_config['slave'][ $this->slave_db_index ]['charset'], $this->db_config['slave'][ $this->slave_db_index ]['user'], $this->db_config['slave'][ $this->slave_db_index ]['pwd']);
            }
        } catch (\PDOExcetion $e) {
            //throw
        }
    }


    public function select($sql, array $params = [])
    {
        $this->instance = $this->conn->prepare($sql);
        if ($this->instance->execute($params)) {
            return $this->instance->fetchAll(\PDO::FETCH_ASSOC);
        }
    }


    public function insert($sqls, $params)
    {
        $this->is_insert_mode = true;
        foreach ($sqls as $key => $sql) {
            $this->query($sql, $params[ $key ]);
        }

        return $this->insert_id;
    }


    public function add($sql, $params)
    {
        $this->is_insert_mode = true;
        foreach ($params as $key => $param) {
            $this->query($sql, $param);
        }

        return $this->insert_id;
    }


    public function query($sql, $param)
    {
        $this->instance = $this->conn->prepare($sql);

        if ($this->instance->execute($param)) {
            $this->correct_query_res++;
        }

        if ($this->is_insert_mode) {
            $this->insert_id[] = $this->conn->lastInsertId();
        }

        return $this->correct_query_res;
    }

}