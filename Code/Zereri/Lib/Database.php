<?php
namespace Zereri\Lib;

class Database
{

    /**数据库pdo连接
     *
     * @var \PDO
     */
    protected $conn;


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


    public function __construct()
    {
        $this->conn = Register::get("database") ?: $this->registerDB();
    }


    /**注册数据库连接并且返回
     *
     * @return \PDO
     */
    protected function registerDB()
    {
        $conn = $this->connectDB();
        Register::set("database", $conn);

        return $conn;
    }

    /**数据库连接
     *
     * @return \PDO
     */
    protected function connectDB()
    {
        try {
            return new \PDO($GLOBALS['user_config']['database']['drive'] . ":host=" . $GLOBALS['user_config']['database']['host'] . ";dbname=" . $GLOBALS['user_config']['database']['dbname'], $GLOBALS['user_config']['database']['user'], $GLOBALS['user_config']['database']['pwd']);
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