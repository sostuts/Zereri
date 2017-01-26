<?php
namespace Zereri\Lib;

use Zereri\Lib\Cache\Redis;

class Queue
{
    /**Redis连接
     *
     * @var Redis
     */
    private $redis;


    /**类名
     *
     * @var Object
     */
    private $instance;


    /**延迟时间
     *
     * @var int
     */
    private $time;


    public function __construct()
    {
        $this->redis = new Redis();
        $this->time = time();
    }


    /**添加类到队列
     *
     * @param string $class
     * @param array  $params
     *
     * @return $this
     */
    public function add($class, array $params = [])
    {
        $this->instance = json_encode(["class" => $class, "params" => $params, "time" => $this->time]);

        return $this;
    }


    /**时间延迟
     *
     * @param $time
     */
    public function delay($time = 0)
    {
        $this->time += $time;
    }


    public function __destruct()
    {
        if ($this->time) {
            return $this->redis->zadd("queue:delay", $this->time, $this->instance);
        }

        $this->redis->lPush("queue", $this->instance);
    }
}