# 中间件

### 创建中间件

/App/Middles/Test.php

``` php
<?php
namespace App\Middles;

class Test implements MiddleWare
{
    public function before($request)
    {
        echo "first one";
    }

    public function after($request)
    {
        echo "goodBye!";
    }
}
```

- 中间件必须实现 **before** 和 **after** 两个方法 ， 两者分别是**前置中间件**以及**后置中间件** 。
- 两个方法的参数为**$request** ，参数值为解析之后的HTTP传参数据 。
- 若想在**前置中间件中结束整个进程**，`return fales;` 即可实现。


<br/>

### 调用中间件

/App/Config/route.php

```php
<?php

return [
    //URL_0 调用了 Test 中间件
    "/URL_0" => [
        "GET" => ["First@test", 'Test']
    ],

    //URL_1 调用了 Example、Test 两个中间件
    "/URL_1" => [
        "GET" => ["First@aaa", ['Example', 'Test']]
    ]
];
```

<br/>

##### 例子：

- 控制器：/App/Controllers/First.php

``` php
<?php
namespace App\Controllers;

class First
{
    public function hello($word = "Zereri")
    {
        response(200, ["word" => $word]);
    }
}
```

- 路由器：/App/Config/route.php

```php
<?php

return [
    "/test"     => [
        "GET" => ["First@hello", 'Example']
    ],
    "/test/{word}" => [
        "GET" => ["First@hello", ['Example', 'Test']]
    ]
];
```

- 中间件：/App/Middles/Test.php 、 /App/Middles/Example.php  


- 访问服务器

input : http://YourDomain/test

result : `first one Zereri `

<br/>

input : http://YourDomain/test/yes

result : `hello! first one yes `

<br/>

### 分组中间件

/App/Config/route.php

```php
<?php

return [
  	//添加User、Admin分组
    "MiddleWareGroups" => [
      	//"GroupName" => [Middleware, Middleware2, Middleware3]
        "User"  => "Example_gourp",
        "Admin" => ["Example_gourp", "Test_gourp"]
    ],
  
  	//调用了User分组
    "/test"            => [
        "GET" => ["First@hello", 'Example', 'User']
    ],
  
  	//调用了Admin分组
    "/test/{word}"     => [
        "GET" => ["First@hello", ['Example', 'Test'], 'Admin']
    ]
];
```

- 调用了User分组的 **/test**  路由，实际调用了 **Example_gourp、Example 两个**中间件
- 调用了Admin分组的 **/test/{word}** 路由，实际调用了 **Example_gourp、Test_gourp、Example、Test 四个**中间件

<br/>

### 全局中间件

```php
<?php

return [
    "MiddleWareGroups" => [
        "User"  => "Example_gourp",
        "Admin" => ["Example_gourp", "Test_gourp"],
      
      	//添加了全局中间件
      	"ALL"   => ["Example_global", "Test_global"]
    ],
  
  	//调用了User分组
    "/test"            => [
        "GET" => ["First@hello", 'Example', 'User']
    ],
  
  	//调用了Admin分组
    "/test/{word}"     => [
        "GET" => ["First@hello", ['Example', 'Test'], 'Admin']
    ]
];
```

- 仅需要在`MiddleWareGroups` `ALL` 中添加将要调用的中间件类名即可， **所有路由将会调用**该全局中间件。
- 调用了User分组的 **/test**  路由，实际调用了 **Example_global、Test_global、**Example_gourp、Example **四个**中间件
- 调用了Admin分组的 **/test/{word}** 路由，实际调用了 **Example_global、Test_global、**Example_gourp、Test_gourp、Example、Test **六个**中间件

<br/>

### 先后顺序

- **全局**中间件 >> **分组**中间件 >> 各个路由中的中间件
- 每个数组中都按顺序一一调用