## 中间件

#### 创建中间件

/App/Middles/Test.php

``` php
<?php
namespace App\Middles;

class Test implements MiddleWare
{
    public function before($request)
    {
        echo "hello!";
    }

    public function after($request)
    {
        echo "goodBye!";
    }
}
```

- 中间件必须实现 **before** 和 **after** 两个方法 ， 两者分别是**前置中间件**以及**后置中间件** 。
- 两个方法的参数为**$request** ，参数值为接受并解析之后的Post内容 。
- 若想在**前置中间件中结束整个进程**，`return fales;` 即可实现。



#### 控制器调用中间件

``` php
<?php
......

public $middle = [
    //method1方法调用 Middle1中间件
    "method1" => "Middle1",

    //method2方法调用 Middle2,Middle3,Middle4 三个中间件
    "method2" => ["Middle2", "Middle3", "Middle4"],

    //控制器里所有方法都调用 Middel5,Middel6 两个中间件
    "all"     => ["Middle5", "Middle6"]
];
```



##### 例子：

/App/Controllers/Example.php

``` php
<?php
namespace App\Controllers;

class Example
{
    public $middle = [
        "all" => "Test",
        "exp" => ["Auth", "Mail"]
    ];

    public function exp()
    {
        response(["data" => "i am Zereri."]);
    }

    public function welcome()
    {
        response(["title" => "Welcome"]);
    }
}
```

- exp() 方法调用 **Test,Auth,Mail** 三个中间件。
- welcome() 方法调用 **Test** 中间件。

