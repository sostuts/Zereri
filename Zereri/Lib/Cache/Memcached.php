<?php
namespace Zereri\Lib\Cache;

class Memcached implements \Zereri\Lib\Interfaces\Cache
{
    /**memcache对象
     *
     * @var object
     */
    private $memcached;


    public function __construct()
    {
        $this->memcached = $this->newInstance();
    }


    protected function newInstance()
    {
        $instance = new \Memcached();
        $this->addConfigServerListToMemcached($instance);

        return $instance;
    }


    protected function addConfigServerListToMemcached(&$instance)
    {
        $instance->addServers(config("memcached.server"));
    }


    public function set($key, $value = "", $time = "")
    {
        if (is_array($key)) {
            return $this->setMulti($key, $time);
        }

        return $this->commonOperate("set", $key, $value, $time ?: config("cache.time"));
    }


    public function has($key)
    {
        return !empty($this->commonOperate("get", $key));
    }


    public function get($key)
    {
        if (is_array($key)) {
            return $this->getMulti($key);
        }

        return $this->commonOperate("get", $key);
    }


    public function delete($key)
    {
        return $this->commonOperate("delete", $key);
    }


    public function flush()
    {
        $this->memcached->flush();
    }


    public function increment($key, $num = 1)
    {
        return $this->commonOperate("increment", $key, $num);
    }


    public function decrement($key, $num = 1)
    {
        return $this->commonOperate("decrement", $key, $num);
    }


    public function setMulti(array $values, $time = "")
    {
        return $this->commonOperate("setMulti", $values, $time ?: config("cache.time"));
    }


    public function getMulti(array $values)
    {
        return $this->commonOperate("getMulti", $values);
    }


    protected function commonOperate($operation, ...$params)
    {
        if ($data = $this->memcached->{$operation}(...$params)) {
            return $data;
        }

        return $this->memcached->getResultCode();
    }


    public function __call($method, $params)
    {
        return $this->commonOperate($method, $params);
    }
}