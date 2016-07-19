<?php
namespace Zereri\Lib;

class Memcache
{
    /**memcache对象
     *
     * @var object
     */
    private $memcache;


    public function __construct()
    {
        $this->newInstance()->addServer();
    }


    /**实例化memcache
     *
     * @return $this
     */
    public function newInstance()
    {
        $this->memcache = new \Memcached();

        return $this;
    }


    /**
     * 添加服务器
     */
    public function addServer()
    {
        $this->memcache->addServers($GLOBALS['user_config']['memcached']['server']);
    }


    /**添加或修改数据
     *
     * @param        $key
     * @param        $value
     * @param string $time
     *
     * @return int
     */
    public function set($key, $value = "", $time = "")
    {
        if (is_array($key)) {
            return $this->setMulti($key, $time);
        }

        return $this->operate("set", $key, $value, $time ?: $GLOBALS['user_config']['memcached']['time']);
    }


    /**获取数据
     *
     * @param $key
     *
     * @return int
     */
    public function get($key)
    {
        if (is_array($key)) {
            return $this->getMulti($key);
        }

        return $this->operate("get", $key);
    }


    /**删除指定数据
     *
     * @param $key
     *
     * @return int
     */
    public function delete($key)
    {
        return $this->operate("delete", $key);
    }


    /**
     * 删除所有数据
     */
    public function flush()
    {
        $this->memcache->flush();
    }


    /**数据值增加
     *
     * @param     $key
     * @param int $num
     *
     * @return int
     */
    public function increment($key, $num = 1)
    {
        return $this->operate("increment", $key, $num);
    }


    /**数据值减少
     *
     * @param     $key
     * @param int $num
     *
     * @return int
     */
    public function decrement($key, $num = 1)
    {
        return $this->operate("decrement", $key, $num);
    }


    /**添加多值
     *
     * @param array  $values
     * @param string $time
     *
     * @return int
     */
    public function setMulti(array $values, $time = "")
    {
        return $this->operate("setMulti", $values, $time ?: $GLOBALS['user_config']['memcached']['time']);
    }


    /**获取多值
     *
     * @param array $values
     *
     * @return int
     */
    public function getMulti(array $values)
    {
        return $this->operate("getMulti", $values);
    }


    /**memcache公共操作
     *
     * @param       $operation
     * @param array ...$params
     *
     * @return int
     */
    public function operate($operation, ...$params)
    {
        if ($data = $this->memcache->{$operation}(...$params)) {
            return $data;
        }

        return $this->memcache->getResultCode();
    }


    public function __destruct()
    {
        $this->memcache->quit();
    }
}