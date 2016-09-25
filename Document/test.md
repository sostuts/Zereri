### 测试

``` 
因框架的特殊性，大部分情况只需要对接口进行单元化测试，所以使用curl 配合 PHPUnit 即可满足平时的测试需求。
```



##### Curl

框架已经封装了Curl函数，引用 **Zereri\Lib\Test** 类即可。

``` php
<?php

Test::curl($url, $post = "", $header = ["Content-Type" => "text/json"], $cookie = "");

例子：
  Test::curl("http://localhost/index/index", json_encode(["column" => "value"]));
```



##### 配合PHPUnit

- 控制器

``` php
<?php
......

public function index($name, $age)
{
	response($name.$age, "text");  
}
```

- 测试文件

``` php
<?php
require "../Zereri/Lib/Test.php";

use Zereri\Lib\Test;

class UserTest extends PHPUnit_Framework_TestCase
{
	public function testApp()
    {
      	//测试数据
      	$data = [
            "name" => "test",
            "age"  => 13
        ];

    	//获取API返回值
    	$resp = Test::curl("http://localhost/Index/index", json_encode($data));

        //断言相等
        $this->assertEquals("test13", $resp["result"]);
    }
}
```