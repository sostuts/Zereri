## Api文档生成

框架根据控制器的注释生成文档，在需要生成文档的**方法前面加上注释**即会生成文档，可有效提高开发效率。



#### 注释样本

``` php
<?php
/**这里写接口的说明
 *
 * @param  string $content 详细内容
 *
 * @return xml content.真实的内容
 */
```



- 参数说明：`@param type $name need descriment`

| type       | 参数的类型                     |
| ---------- | ------------------------- |
| $name      | 参数的名字                     |
| need       | 是否必须， 1为是， 0为否，**不填默认为1** |
| descriment | 参数的详细说明                   |

- 返回值说明：`@return type name1.desc1 name2.desc2`

| type        | 返回值的类型: json, xml, html 。不填默认为json |
| ----------- | ---------------------------------- |
| name1.desc1 | 第一个返回值的名字.说明                       |
| name2.desc2 | 第二个返回值的名字.说明                       |
| nameN.descN | 第N个返回值的名字.说明                       |

#### 例子1

/App/Controllers/Project.php



此控制器有一个welcome方法，传入名字年龄，返回真实的名字年龄

``` php
<?php
.....

public function welcome($name, $age = 0)
{
  	response([
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
 * @param  string $name 名字
 * @param  int    $age  0 年龄
 *
 * @return user.用户的名字 age.用户的年龄
 */
public function welcome($name, $age = 0)
{
  	response([
      "user" => $name,
      "age"  => $age
    ]);
}
```

访问: http://domain/Api/index 即可查看接口文档。



#### 例子2



/App/Controllers/Project.class.php

此控制器有一个findPwd方法，传入账号，返回密码

``` php
<?php
...

public function findPwd($user)
{
    $password = Dbconn... ;
    response(["password" => $password], "xml");
}
```

添加注释：

``` php
<?php
...

/**找回密码
 *
 * @param  string $user 用户的账号
 *
 * @return xml password.用户的密码
 */
public function findPwd($user)
{
    $password = Dbconn... ;
    response(["password" => $password], "xml");
}
```

访问: http://domain/Api/index 即可查看接口文档。



#### 提示

- 方法**有默认值**的参数，可以在注释说明不是必须值。
- 配合**生成函数注释的插件**可以有效提高工作效率。
- 在不需要生成文档的函数，函数前面不需要添加注释，或者可使用`/**/`或者`//` 注释。
- 控制器中**非函数的注释请用**`/**/`**或者**`//` 。