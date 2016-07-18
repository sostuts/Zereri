## Session

#### 配置

/App/Config/config.php

``` php
<?php
'session'   => [
    'drive' => 'file'
]
```

默认为以文件形式储存session，可以以缓存形式储存，修改为**memcached**即可。



#### 使用

控制器中直接调用Session类即可操作session。



- 获取数据

`$value = Session::get("key");`



- 添加、修改数据

`Session::set("key", "value");`



- 删除数据

`Session::remove("key");`



#### 例子

- 添加一个值为二维数组的数组，**获取第二维的某个值**，最后删除整个session。

``` php
<?php

$values = [
  	"data" => ["name" => "zereri", "age" => 0],
  	"time" => "1999-1-1"
]
  
//add  
Session::set("test", $values);

//echo 0
echo Session::get("test.data.age"); 

//delete
Session::remove("test");
```