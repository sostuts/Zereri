<?php
namespace Zereri\Lib;

class Database
{

    /**数据库pdo连接
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
    protected $slave_num;


    /**预处理实例
     *
     * @var object
     */
    protected $instance;


    /**是否是插入模式
     *
     * @var bool
     */
    protected $insert_mode;


    /**数据插入的id
     *
     * @var array
     */
    protected $insert_id;


    /**正确执行sql语句的次数
     *
     * @var int
     */
    protected $correct_query_res;


    public function __construct($crud = "")
    {
        $this->crud = $crud;
        $this->conn = $this->getConnection();
    }


    /**获取数据库连接
     *
     * @return \PDO
     */
    protected function getConnection()
    {
        if ($this->crud === 'select' && $this->getSalveNum()) {
            return Register::get("database_slave") ?: $this->registerDB("slave");
        }

        return Register::get("database_master") ?: $this->registerDB("master");
    }


    /**挑选一台从库服务器
     *
     * @return bool
     */
    protected function getSalveNum()
    {
        switch ($count = count($GLOBALS['user_config']['database']['slave'])) {
            //no break at all
            case 0:
                return false;
            case 1:
                $this->slave_num = 0;

                return true;
            default:
                $this->slave_num = time() % $count;

                return true;
        }
    }


    /**注册数据库连接并且返回
     *
     * @param string $host 连接的主或从数据库
     *
     * @return \PDO
     */
    protected function registerDB($host)
    {
        $conn = $this->connectDB($host);
        Register::set("database_" . $host, $conn);

        return $conn;
    }


    /**数据库连接
     *
     * @param string $host 连接的主或从数据库
     *
     * @return \PDO
     */
    protected function connectDB($host)
    {
        try {
            if ("master" === $host) {
                return new \PDO($GLOBALS['user_config']['database']['master']['drive'] . ":host=" . $GLOBALS['user_config']['database']['master']['host'] . ";dbname=" . $GLOBALS['user_config']['database']['master']['dbname'] . ";charset=" . $GLOBALS['user_config']['database']['master']['charset'], $GLOBALS['user_config']['database']['master']['user'], $GLOBALS['user_config']['database']['master']['pwd']);
            } else {
                return new \PDO($GLOBALS['user_config']['database']['slave'][ $this->slave_num ]['drive'] . ":host=" . $GLOBALS['user_config']['database']['slave'][ $this->slave_num ]['host'] . ";dbname=" . $GLOBALS['user_config']['database']['slave'][ $this->slave_num ]['dbname'] . ";charset=" . $GLOBALS['user_config']['database']['slave'][ $this->slave_num ]['charset'], $GLOBALS['user_config']['database']['slave'][ $this->slave_num ]['user'], $GLOBALS['user_config']['database']['slave'][ $this->slave_num ]['pwd']);
            }
        } catch (\PDOExcetion $e) {
            //throw
        }
    }


    /**数据库select查询
     *
     * @param       $sql
     * @param array $params
     *
     * @return array
     */
    public function select($sql, array $params = [])
    {
        $this->instance = $this->conn->prepare($sql);
        if ($this->instance->execute($params)) {
            return $this->instance->fetchAll(\PDO::FETCH_ASSOC);
        }
    }


    /**多条sql插入操作
     *
     * @param array $sqls
     * @param array $params
     *
     * @return array
     */
    public function insert($sqls, $params)
    {
        $this->insert_mode = true;
        foreach ($sqls as $key => $sql) {
            $this->query($sql, $params[ $key ]);
        }

        return $this->insert_id;
    }


    /**固定sql数据插入操作
     *
     * @param string $sql
     * @param array  $params
     *
     * @return array
     */
    public function add($sql, $params)
    {
        $this->insert_mode = true;
        foreach ($params as $key => $param) {
            $this->query($sql, $param);
        }

        return $this->insert_id;
    }


    /**数据库增删改操作
     *
     * @param $sql
     * @param $param
     *
     * @return int
     */
    public function query($sql, $param)
    {
        $this->instance = $this->conn->prepare($sql);

        if ($this->instance->execute($param)) {
            $this->correct_query_res++;
        }

        if ($this->insert_mode) {
            $this->insert_id[] = $this->conn->lastInsertId();
        }

        return $this->correct_query_res;
    }

}