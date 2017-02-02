<?php
namespace Zereri\Lib\Cache;

class Redis implements \Zereri\Lib\Interfaces\Cache
{
    /**redis实例
     *
     * @var \Redis
     */
    private $redis;


    public function __construct()
    {
        $this->redis = $this->newInstance();
    }


    protected function newInstance()
    {
        $config = config("redis");
        if (!$config["cluster"]) {
            return $this->connectSingleRedis($config["server"][0], $config["server"][1], $config["auth"]);
        } else {
            return $this->conncetClusterRedis($config["server"], $config["auth"]);
        }
    }


    protected function connectSingleRedis($host, $port, $auth)
    {
        $instance = new \Redis();
        $instance->connect($host, $port);
        $instance->auth($auth);

        return $instance;
    }


    protected function conncetClusterRedis($hosts, $auth)
    {
        $options = [
            'cluster'    => 'redis',
            'parameters' => [
                'password' => $auth
            ]
        ];

        return new \Predis\Client($hosts, $options);
    }


    public function set($key, $value = "", $time = "")
    {
        if (is_array($key)) {
            $time = $value ?: config("cache.time");
            foreach ($key as $each_key => $each_value) {
                $this->redis->setex($each_key, $time, $each_value);
            }

            return 1;
        }

        return $this->redis->setex($key, $time ?: config("cache.time"), $value);
    }


    public function get($key)
    {
        if (is_array($key)) {
            $result = [];
            foreach ($key as $each_key) {
                $result[ $each_key ] = $this->redis->get($each_key);
            }

            return $result;
        }

        return $this->redis->get($key);
    }


    public function has($key)
    {
        return $this->redis->exists($key);
    }


    public function delete($key)
    {
        return $this->redis->del($key);
    }


    public function increment($key, $num = 1)
    {
        return $this->redis->incrby($key, $num);
    }


    public function decrement($key, $num = 1)
    {
        return $this->redis->decrby($key, $num);
    }


    public function flush()
    {
        return $this->redis->flushAll();
    }


    public function __call($func, $arguments)
    {
        $this->redis->$func(...$arguments);
    }
}