### Memcache

框架已经封装Memcache类，控制器里直接使用即可。使用此类前**请确保服务器上的PHP已经扩展了Memcached** 。



#### 配置

/App/Config/config.php

``` php
<?php
'memcached' => [
		//默认过期时间
        'time'   => 3600,
        'server' => [
        	//此处添加服务器
            ['127.0.0.1', 11211]
        ]
]
```



##### Set

添加或修改数据

``` php
<?php
//单条数据
Memcache::set("key", "value", "time");

//多条数据
Memcache::set([
  "key1" => "value1",
  "key2" => "value2"
], "time");
```

提示：时间默认值为3600s。



##### Get

获取数据

``` php
<?php
//单条数据
Memcache::get("key");

//多条数据
Memcache::get(["key1", "key2", "key3"]);
```



##### Delete

删除指定数据

``` php
<?php

Memcache::delete("key");
```



##### Flush

删除所有数据

``` php
<?php

Memcache::flush();
```



##### Increment

数据值增加

``` php
<?php

Memcache::increment("key", "num");

//Core键对应的值加 1
Memcache::increment("Core");

//Age键对应的值加 3
Memcache::increment("Age", 3);
```



##### Decrement

数据值减少

``` php
<?php

Memcache::decrement("key", "num");

//Core键对应的值减 1
Memcache::decrement("Core");

//people键对应的值减 7
Memcache::decrement("people", 7);
```



