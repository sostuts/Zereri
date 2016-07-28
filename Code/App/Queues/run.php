<?php

class Run
{
    /**redis连接
     *
     * @var Redis
     */
    private $redis;


    public function __construct()
    {
        $this->redis = $this->connect();
    }


    /**redis实例化
     *
     * @return Redis
     */
    protected function connect()
    {
        $redis = new Redis();
        $config = $this->getConfig();
        $redis->pconnect($config["server"][0], $config["server"][1]);

        return $redis;
    }


    /**获取redis服务器配置
     *
     * @return mixed
     */
    protected function getConfig()
    {
        return config("redis");
    }


    /**
     * 开始处理队列
     */
    protected function go()
    {
        while (true) {
            sleep(1);
            if ($instance = $this->delayToQueue()->pop()) {
                $this->handle($instance);
            }
        }
    }


    /**redis pop
     *
     * @return array
     */
    protected function pop()
    {
        return json_decode($this->redis->rPop("queue"), true);
    }


    /**队列实例执行方法
     *
     * @param $instance
     *
     * @return mixed
     */
    protected function handle($instance)
    {
        return (new $instance["class"](...$instance["params"]))->run();
    }


    /**将延迟任务推到队列中
     *
     * @return $this
     */
    protected function delayToQueue()
    {
        $time = time();

        if ($instances = $this->getSet($time)) {
            $this->removeSet($time)->addToList($instances);
        }

        return $this;
    }


    /**获取到时任务
     *
     * @param $time
     *
     * @return array
     */
    protected function getSet($time)
    {
        return $this->redis->zRangeByScore("queue:delay", 0, $time);
    }


    /**删除过期任务
     *
     * @param $time
     *
     * @return $this
     */
    protected function removeSet($time)
    {
        $this->redis->zRemRangeByScore("queue:delay", 0, $time);

        return $this;
    }


    /**任务添加到列表中
     *
     * @param $instances
     */
    protected function addToList($instances)
    {
        foreach ($instances as $e_instance) {
            $this->redis->lPush("queue", $e_instance);
        }
    }

    /**
     * 守护进程
     */
    public function start()
    {
        if ($this->existFork()) {
            $this->fork();
        } else {
            $this->go();
        }
    }


    /**判断是否可以fork
     *
     * @return bool
     */
    protected function existFork()
    {
        return function_exists("pcntl_fork");
    }


    /**
     * fork子进程并成为守护进程
     */
    protected function fork()
    {
        $pid = pcntl_fork();
        if ($pid === 0) {
            $this->forkDeamon();
        } elseif ($pid > 0) {
            exit();
        } else {
            $this->go();
        }
    }


    /**
     * 子进程处理队列
     */
    protected function forkDeamon()
    {
        posix_setsid();

        pcntl_fork() === 0 ? $this->go() : pcntl_wait($status, WUNTRACED);
    }
}


require_once '../../Zereri/load.php';

(new Run())->start();
