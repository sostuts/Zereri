## 控制器

#### 创建第一个Controller

- 新建：/App/Controllers/First.php

``` php
<?php
namespace App\Controllers;

class First
{
  	//新建一个hello方法
    public function hello()
    {
        response(200, "hello");
    }
}
```

- 配置路由 /App/Config/route.php

``` php
<?php

return [
    "/hello"  => [
        "GET"  => "First@hello"
    ]
];
```

- Get方法访问 http://localhost/hello 返回值：`"hello"`

<br/>

#### 返回Json的控制器

``` php
<?php
//框架辅佐函数response()
void response($status_code, $data = NULL, $mode = 'json', $file = '', $header = "")
```

| $mode       | Description            |
| ----------- | ---------------------- |
| status_code | HTTP返回状态码, config文件中配置 |
| json        | 转换为json格式，默认           |
| xml         | 转换为xml格式               |
| text        | 纯文本，直接打印               |
| html        | 调用模板引擎                 |

所以只需要将数组放进response第一个参数即可。

``` php
<?php
namespace App\Controllers;

class First
{
    public function jsonTest()
    {
        $result = ["name" => "Ben", "age" => 14];
        response(200, $result);
    }
}
```

返回值：`{"name":"Ben","age":14}`

<br/>

#### 返回xml的控制器

``` php
<?php
namespace App\Controllers;

class First
{
    public function xmlTest()
    {
        $result = ["name" => "Ben", "age" => 14];
        response(200, $result, "xml");
    }
}
```

返回值:

``` 
<root>
<name>Ben</name>
<age>14</age>
</root>
```

<br/>

#### 返回html的控制器

框架引用了Smarty，模板存放在**/App/Tpl** 里，模板使用Smarty语法即可，控制器使用**response()**方法调用Smarty。

``` php
<?php
namespace App\Controllers;

class First
{
    public function htmlTest()
    {
        $data = ["name" => "Ben", "age" => 14];
      	//模板中使用 <{$name}>  <{$age}> 即可调用该数组中的变量
        response(200, $data, "html", "index.tpl");
    }
}
```

/App/Tpl/index.tpl 代码如下:

``` 
I am <{$name}>, <{$age}> years old.
```

返回值：

``` 
I am Ben, 14 years old.
```

<br/>

#### 带参数的控制器

在前后端分离的项目中，接口的参数是必要的，在Zereri框架中，**接口的参数**是将会**是方法的参数**。

`例如：前端传入一个人的名字，后台返回那个人的年龄。`

**Controller:**    /App/Controllers/Project.php

``` php
<?php
namespace App\Controllers;

class Project
{
    public function getAge($name)
    {
        $data = ["age" => 111];
        response(200, $data);
    }
}
```

**Route:**

``` php
<?php

return [
    "/age" => [
        "GET" => "Project@getAge"
    ]
];
```

**Post:**

- Url:http://localhost/age
- Data:`{"name":"Ben"}`       [此处的**name字段与函数的参数名对应**]

**Return:**

``` 
{"age":111}
```

<br/>

#### 返回带Header的控制器

``` php
<?php
namespace App\Controllers;

class Project
{
    public function getData($name, $age, $id)
    {
        $data = ["content" => $name.$age.$id];
      	$header = [
          "Content-Type" => "text/html",
          "Server" 		 => "Apache"
        ];
        response(200, $data, "", "", $header);
    }
}
```

<br/>

#### 控制器访问配置值

访问配置值：`config($name);` 

例如

``` php
<?php

echo config("https_port"); //返回值 : 443
```

