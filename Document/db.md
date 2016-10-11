## 数据库配置

/App/Config/config.php

``` php
<?php
'database'  => [
    'master' => [
        "drive"   => "mysql",               //目前仅支持mysql
        "host"    => "localhost",           //主库地址
        "dbname"  => "zereri",              //数据库名字
        "user"    => "root",                //数据库用户名
        "pwd"     => "root",                //数据库用户密码
        "charset" => "utf8"                 //设置字符集
    ],

    //若无从库则 'slave' => []
    'slave'  => [
        [
            "drive"   => "mysql",               //目前仅支持mysql
            "host"    => "localhost",           //从库一地址
            "dbname"  => "zereri",              //数据库名字
            "user"    => "root",                //数据库用户名
            "pwd"     => "root",                //数据库用户密码
            "charset" => "utf8"                 //设置字符集
        ],
        [
            "drive"   => "mysql",               //目前仅支持mysql
            "host"    => "localhost",           //从库二地址
            "dbname"  => "zereri",              //数据库名字
            "user"    => "root",                //数据库用户名
            "pwd"     => "root",                //数据库用户密码
            "charset" => "utf8"                 //设置字符集
        ]
    ]
]
```

## 查询构造器

框架提供了辅佐函数 **TB()** 对数据库进行操作，下面将对该函数进行逐步举例说明。

<br/>

### select

##### 简括：执行select语句查询数据

##### 用法：

- 简单查询

``` php
<?php

#全表查询
TB('table')->select();

#指定列名查询
TB('table')->select('column1,column2,column3');
#另一种写法
TB('table')->select(['column1', 'column2', 'column3']);
```

<br/>

- 简单where条件查询【where、orWhere、andWhere】

``` php
<?php

//查询id大于6的数据
TB('users')->where('id', '>', 6)->select();

//查询id小于3  或者  age等于6的数据
TB('users')->where('id', '>', 6)->orWhere('age', '=', 6)->select();

//查询name等于zereri  并且  password等于nice的数据
TB('users')->where('name', '=', 'zereri')->andWhere('password', '=', 'nice')->select();
```

<br/>

- In语句【whereIn、whereNotIn】

``` php
<?php

用法：whereIn('column', [value1, value2, value3])

//查询id为1357的数据
TB('users')->whereIn('id', [1, 3, 5, 7])->select();
```

<br/>

- Null语句【whereNull、whereNotNull】

``` php
<?php

用法：whereNull('column')

//查询id不为null的数据
TB('users')->whereNotNull('id')->select();
```

<br/>

- Between语句【whereBetween、whereNotBetween】

``` php
<?php

用法：whereBetween('column', 'value1', 'value2')

//查询id在1-10区间的数据
TB('users')->whereBetween('id', 1, 10)->select();
```

<br/>

- 复杂where条件语句【whereOrWhere、whereAndWhere、_or、_and】

``` php
<?php

用法：
1.whereOrWhere(['column1', '=', 'value1'], ['column2', '=', 'value2'])
  //SQL： (column1 = value1) OR (column2 = value2)

2. _or()
  //SQL："OR"

例子：
TB('users')->whereOrWhere(['name', '=', 'zereri'], ['password', '=', 'test'])
			->_or()
            ->whereAndWhere(['id', '=', '7'], ['name', '=', 'zeffee'])
            ->select('name,id');

	SQL:  SELECT name,id FROM users 
		  WHERE 
          ((name = 'zereri') OR (password = 'test')) 
          AND 
          ((id = 7) AND (name = 'zeffee'));
		
```

<br/>

- Raw (执行原生Select SQL)

``` php
<?php

用法:raw('sql', ['value1', 'value2'])

//查询id为12的数据。
TB()->raw('select * from users where id=?', [12]);
```

<br/>

- 聚合函数【count、max、min、avg、sum、concat】

``` php
<?php

用法：count('alias')    ||    max('column', 'alias')

//查询core列平均值
TB('users')->avg('core')->select("id");

//查询name为Ben中的最小age值的数据,并将最小值age的列名改为old
TB('users')->where('name', '=', 'Ben')->min('age', 'old')->select();
```

<br/>

- orderBy语句

``` php
<?php

用法：orderBy('column1','column2')

//name倒序,password顺序排列
TB('users')->orderBy('name desc', 'pwd')->select();
```

<br/>

- groupBy语句【groupBy、having、havingRaw】

``` php
<?php

用法：groupBy('column1','column2')
	  having('column','=','value')

//以name、pwd分组，从中挑选age大于14的数据
TB('users')->groupBy('name', 'pwd')->having("age", ">", "14")->select();
TB('users')->groupBy('name', 'pwd')->havingRaw("age > 14")->select();
```

<br/>

- limit语句

``` php
<?php

//取第三条到第五条数据
TB('users')->limit(2, 3)->select();
```

<br/>

- InnerJoin语句

``` php
<?php

用法：join('table','column1','=','column2')

//与单表内连接
TB('a')->join('b','a.name','=','b.name')->select();

//与多表内连接
TB('a') ->join('b', 'a.name', '=', 'b.name')
		->join('c', 'c.age',  '=', 'a.age')
        ->join('d', 'd.pwd',  '=', 'a.pwd')
        ->where('id','>',10)
        ->select();
```

<br/>

- leftJoin语句

``` php
<?php

用法：leftJoin('table','column1','=','column2')

//与单表左连接
TB('users')->leftJoin('test','users.id','=','test.id')->select();

//与多表左连接
TB('a') ->leftJoin('b', 'a.name', '=', 'b.name')
		->leftJoin('c', 'c.age',  '=', 'a.age')
        ->leftJoin('d', 'd.pwd',  '=', 'a.pwd')
        ->whereNotNull('a.name')
        ->select();
```

<br/>

## insert

##### 简括：执行单条或者多条sql insert语句。

##### 用法：

- 单条插入:

``` php
TB('table')->insert(['column1' => 'value1', 'column2' => 'value2']);
```

- 多条插入:

``` php
TB('table')->insert([
	['column1' => 'value1', 'column2' => 'value2'],
	['column3' => 'value3', 'column4' => 'value4']
]);
```

##### 例子：

- 插入单条数据

``` php
<?php

$res = TB('test')->insert([
    'date' => '2015-9-18 1:5:55',
	'id'   => 55
]);
```

- 插入多条数据

``` php
<?php

$res = TB('users')->insert([    
	['name' => 'Jan, 'password' => '1234566'],
	['name' => 'Ben', 'password' => '678']
]);
```

结果会返回插入数据库的行数（**对应自增的主键ID**）。

``` php
# 返回值
Array
(
    [0] => 55
)
```

<br/>

### add

##### 简括：执行单条sql insert语句并可插入多值。

##### 用法：

``` php
TB('table')->add(['column1', 'column2'], ['value1', 'value2'], ['value3', 'value4']);
```

##### 例子：

- 插入两条数据

``` php
$res = TB('users')->add(['name', 'password'], ['Bike', '123123'], ['Csois', 899]);
```

- 插入四条数据

``` php
<?php

$res = TB('users')->add(
  	//字段
    ['name', 'password'], 
  	
  	//数据
    ['wy', '123123'], 
    ['zeffee', 12], 
    ['Viv', '123123'], 
    ['HK', 666]
);
```

结果会返回插入数据库的行数（**对应自增的主键ID**）。

``` php
# 返回值
Array
(
    [0] => 4
    [1] => 5
    [2] => 6
	[3] => 7
)
```

<br/>

### update

##### 简括：执行update语句更新数据。

##### 用法:

``` php
TB(?)->where(?)->update(['column1' => 'new_value', 'column2' => 'new_value']);
```

##### 例子：

- 把name为zeffee的数据修改为zereri 并且修改其password值

``` php
<?php

$res = TB('users')->where('name', '=', 'zeffee')->update([
     'name'     => 'zereri',
     'password' => 'nice'
]);
```

返回值为影响的行数。

<br/>

### Incremrnt

##### 简括：指定字段数据值增加

##### 用法：

``` 
TB(?)->where(?)->increment("column", num);
```

##### 例子:

- view字段值加1

``` 
TB('articles')->where('id', '=', 66)->increment("view");
```

- view字段值加5

``` 
TB('articles')->where('id', '=', 66)->increment("view", 5);
```

<br/>

### Decrement

##### 简括：指定字段数据值减少

##### 用法：

- 请参考 `Increment` 的使用说明。

<br/>

### delete

##### 简括：执行delete语句删除数据

##### 用法:

``` php
TB(?)->where(?)->delete();
```

##### 例子：

- 删除id为35的数据

``` php
TB('users')->where('id', '=', 35)->delete();
```

返回值为影响的行数。

<br/>

### 事务

- 开始事务

``` php
<?php
//开启事务并进行CRUD操作
TB("test")->beginTransaction()->insert([
      "name" => "Zereri"
]);
```

<br/>

- 回滚事务

``` php
<?php
//开启事务并进行CRUD操作
TB("test")->rollback()->insert([
    "name" => "Zeffee"
]);
```

<br/>

- 提交事务

``` php
<?php

TB("test")->commit();
```