### 测试

``` 
因框架的特殊性，大部分情况只需要对接口进行单元化测试，所以使用curl 配合 PHPUnit 满足平时的测试需求。
```



##### Curl

框架已经封装了Curl函数，引用 **Zereri\Lib\Test** 类即可。

``` php
Test::curl($url, $post = "", $cookie = "", $referer = "", $header = "");

例子：Test::curl("http://localhost/index/index", "column=content");
```



##### 配合PHPUnit

``` php
<?php
require "../Zereri/Lib/Test.class.php";

class UserTest extends PHPUnit_Framework_TestCase
{
	public function testApp()
    {
    	//获取API返回值
    	$resp = Test::curl("http://localhost/index/index", "name=test&age=13");
        
        //断言相等
        $this->assertEquals("test13", $resp["result"]);
    }
}
```