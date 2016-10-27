<?php
namespace Zereri\Lib;

class Redis
{
    /**redis连接
     *
     * @var \Redis
     */
    private $redis;


    public function __construct()
    {
        $this->redis = Register::get("redis") ?: $this->registerInstance();
    }


    /**注册redis实例
     *
     * @return \Redis
     */
    protected function registerInstance()
    {
        $instance = $this->newInstance();
        Register::set("redis", $instance);

        return $instance;
    }


    /**实例化、连接redis服务器
     *
     * @return \Redis
     */
    protected function newInstance()
    {
        $config = config("redis");
        if (!$config["cluster"]) {
            return $this->connectSingleRedis($config["server"][0], $config["server"][1], $config["auth"]);
        } else {
            return $this->conncetClusterRedis($config["server"], $config["auth"]);
        }
    }


    /**连接单台redis服务器
     *
     * @param $host
     * @param $port
     * @param $auth
     *
     * @return \Redis
     */
    protected function connectSingleRedis($host, $port, $auth)
    {
        $instance = new \Redis();
        $instance->connect($host, $port);
        $instance->auth($auth);

        return $instance;
    }


    /**predis连接redis集群
     *
     * @param $hosts
     * @param $auth
     *
     * @return \Predis\Client
     */
    protected function conncetClusterRedis($hosts, $auth)
    {
        $options = [
            'cluster'    => 'redis',
            'parameters' => [
                'password' => $auth
            ]];

        return new \Predis\Client($hosts, $options);
    }


    /**添加或者修改数据
     *
     * @param        $key
     * @param string $value
     * @param string $time
     *
     * @return bool|int
     */
    public function set($key, $value = "", $time = "")
    {
        if (is_array($key)) {
            $time = $value;
            foreach ($key as $each_key => $each_value) {
                $this->redis->setex($each_key, $time ?: config("cache")["time"], $each_value);
            }

            return 1;
        }

        return $this->redis->setex($key, $time ?: config("cache")["time"], $value);
    }


    /**获取数据
     *
     * @param $key
     *
     * @return array|bool|string
     */
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


    /**判断键是否存在
     *
     * @param $key
     *
     * @return bool
     */
    public function has($key)
    {
        return $this->redis->exists($key);
    }


    /**键值增加
     *
     * @param     $key
     * @param int $num
     *
     * @return int
     */
    public function increment($key, $num = 1)
    {
        return $this->redis->incrby($key, $num);
    }


    /**键值减少
     *
     * @param     $key
     * @param int $num
     *
     * @return int
     */
    public function decrement($key, $num = 1)
    {
        return $this->redis->decrby($key, $num);
    }


    /**清空所有数据
     *
     * @return bool
     */
    public function flush()
    {
        return $this->redis->flushAll();
    }


    public function __call($func, $arguments)
    {
        $this->redis->$func(...$arguments);
    }
}