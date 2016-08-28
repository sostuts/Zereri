### 缓存

框架已经封装Redis和Cached缓存类，控制器里直接使用即可。使用此类前**请确保服务器已经安装了PHP的 Memcached扩展** 或者 **Redis 扩展**。



#### 配置

/App/Config/config.php

``` php
<?php
    /**
     * 缓存配置
     */
    'cache'     => [
        "drive" => "redis",		//选择使用redis或者memcached
        'time'  => 3600			//数据的默认过期时间
    ],


    /**
     * Memcached服务器配置
     */
    'memcached' => [
        'server' => [
            ['127.0.0.1', 11211],
          	['IP', Port]			//添加memcached服务器
        ]
    ],


    /**
     * redis服务器配置
     */
    'redis'     => [
        'server' => ["127.0.0.1", 6379]   //设置redis服务器配置
    ],
```



##### Set

添加或修改数据

``` php
<?php
//单条数据
Cache::set("key", "value", "time");

//多条数据
Cache::set([
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
Cache::get("key");

//多条数据
Cache::get(["key1", "key2", "key3"]);
```



##### Has

判断值是否存在

``` php
<?php

Cache::has("key");
```



##### Delete

删除指定数据

``` php
<?php

Cache::delete("key");
```



##### Flush

删除所有数据

``` php
<?php

Cache::flush();
```



##### Increment

数据值增加

``` php
<?php

Cache::increment("key", "num");

//Core键对应的值加 1
Cache::increment("Core");

//Age键对应的值加 3
Cache::increment("Age", 3);
```



##### Decrement

数据值减少

``` php
<?php

Cache::decrement("key", "num");

//Core键对应的值减 1
Cache::decrement("Core");

//people键对应的值减 7
Cache::decrement("people", 7);
```



#### 更多操作

memcached和redis拥有的方法不止以上几个，若想使用其他方法**请调用** `Cache::Func($params)` ，例如：

``` php
<?php
//redis构建无序集合
Cache::sadd($key, $value);

//redis获取key存储类型
Cache::type($key);
```