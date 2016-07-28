## 队列

框架使用Redis进行队列操作，使用前**请确保环境支持Redis**。



#### 创建队列任务类

/App/Queues/Test.php

``` php
<?php
namespace App\Queues;

class Test implements InQueue
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function run()
    {
        echo $this->text;
    }
}
```

- 任务类需要继承InQueue接口，**实现run() 方法** , 该方法包含将要执行的代码。



#### 控制器中添加队列

控制器中使用`Queue::add`即可添加任务至队列

``` php
<?php
//class为任务类类名，params为实例化时的参数
Queue::add($class, array $params = []);

//延迟任务
Queue::add()->delay($time);
```

##### 例子：

``` php
<?php
......

public function example()
{
  	//将上面的Test任务类添加至队列，并且延迟5秒执行
    Queue::add(\App\Queues\Test::class, ["hello"])->delay(5);

    response(["name" => "i am Zereri."]);
}
```

- **启动队列执行程序后**，5s后将会执行Test类的run()方法，即： `echo “hello”;` 。



#### 启动队列执行程序

- 启动 `php /App/Queues/run.php` 。
- 若php支持 pcntl模块，该程序自动成为守护进程。





