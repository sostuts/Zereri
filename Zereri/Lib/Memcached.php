<?php
namespace Zereri\Lib;

class Memcached
{
    /**memcache对象
     *
     * @var object
     */
    private $memcache;


    public function __construct()
    {
        $this->memcache = Register::get("memcache") ?: $this->registerInstance();
    }


    /**注册memcache并返回实例
     *
     * @return Memcached
     */
    protected function registerInstance()
    {
        $instance = $this->newInstance();
        Register::set("memcache", $instance);

        return $instance;
    }


    /**实例化memcached
     *
     * @return $this
     */
    protected function newInstance()
    {
        $instance = new \Memcached();
        $this->addServer($instance);

        return $instance;
    }


    /**添加服务器
     *
     * @param $instance
     */
    protected function addServer(&$instance)
    {
        $instance->addServers($GLOBALS['user_config']['memcached']['server']);
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

        return $this->operate("set", $key, $value, $time ?: $GLOBALS['user_config']['cache']['time']);
    }


    /**判断值是否存在
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return !empty($this->operate("get", $key));
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
        return $this->operate("setMulti", $values, $time ?: $GLOBALS['user_config']['cache']['time']);
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
     * @param array $params
     *
     * @return int
     */
    public function operate($operation, $params)
    {
        if ($data = $this->memcache->{$operation}(...$params)) {
            return $data;
        }

        return $this->memcache->getResultCode();
    }


    public function __call($method, $params)
    {
        return $this->operate($method, $params);
    }
}