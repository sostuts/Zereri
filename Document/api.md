## Api文档生成

     框架根据控制器的注释生成文档，在需要生成文档的**方法前面加上注释**即会生成文档，过程可能会破坏PSR规范,  但会有效提高开发效率。

<br/>

#### 注释样本

``` php
<?php
/**这里写接口的说明
 *
 * @group   hello
 *
 * @header  string token    口令
 *
 * @param  string $content 详细内容
 *
 * @return content:真实的内容
 * @example 成功 {"result":"ok"}
 */
```

- 分组说明：`@group hello`

``` 
hello 为组名，即为文档一级菜单栏名字。
```

- 头部说明：`请参考 参数说明 `


- 参数说明：`@param type $name description`

| type        | 参数的类型   |
| ----------- | ------- |
| $name       | 参数的名字   |
| description | 参数的详细说明 |

- 返回值说明：`@return name1:desc1 name.Yep:desc2`

| 名称             | 说明           |
| -------------- | ------------ |
| name1:desc1    | 第一个返回值的名字:说明 |
| name.Yap:desc2 | 第二个返回值的名字:说明 |
| nameN.descN    | 第N个返回值的名字.说明 |

- 例子说明：`@example condition json_data`

| condition | 具体情况,对此次返回的解释  |
| --------- | -------------- |
| json_data | 返回的具体信息,json格式 |

<br/>

#### 例子1

/App/Controllers/Project.php

此控制器有一个welcome方法，传入名字年龄，返回真实的名字年龄

``` php
<?php
.....

public function welcome($name, $age = 0)
{
  	response(200, [
      "user" => $name . "Belly",
      "age"  => $age + 1
    ]);
}
```

添加注释：

``` php
<?php
.....

/**返回用户真实的名字年龄
 *
 * @group   hello
 *
 * @param  string $name 名字
 * @param  int    $age  年龄
 *
 * @return user:用户的名字 age:用户的年龄
 * @example 成功 {"user":"zeffee","age":20}
 */
public function welcome($name, $age = 0)
{
  	response(200, [
      "user" => $name,
      "age"  => $age
    ]);
}
```

访问: http://domain/api/list 即可查看接口文档。

<br/>

#### 例子2

/App/Controllers/Project.class.php

此控制器有一个findPwd方法，传入账号，判断口令是否合法，返回密码

``` php
<?php
...

public function findPwd($user)
{
    $password = Dbconn... ;
    response(200, ["password" => $password], "xml");
}
```

添加注释：

``` php
<?php
...

/**找回密码
 *
 * @header string AUTHENTICATION 口令认证
 *
 * @param  string $user 用户的账号
 *
 * @return password:用户的密码
 * @example 成功 {"password":"123456"}
 * @example AUTHENTICATION有误 {"message":"error"}
 */
public function findPwd($user)
{
    $password = Dbconn... ;
  	if($_SERVER["HTTP_AUTHENTICATION"] === "nice"){
  		response(200, ["password" => $password]);
	}else{
  		response(404, ["message" => "error"]);
	}
}
```

访问: http://domain/api/list 即可查看接口文档。

<br/>

#### 提示

- 配合**生成函数注释的插件**可以有效提高工作效率。

- 在不需要生成文档的函数，函数前面不需要添加注释，或者可使用`/**/`或者`//` 注释。

- `/api/list` 的接口会产生一定的性能消耗，若在生产环境可以更改或删除该接口。

  ​