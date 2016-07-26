## Model

模型层，直观操作数据库层，并提供一对一、 一对多 和 多对多 的关联模式。



#### 模型创建

在 **/App/Models/** 文件夹下创建  Users.php

``` php
<?php
namespace App\Models;

class Users extends Model
{

}
```

表名默认为**类名的小写**，上例即为 **users**表。可以通过**$table**属性指定表名。

``` php
<?php
namespace App\Models;

class Users extends Model
{
  	//声明该模型指定student表
	protected $table = "student";
}
```



#### 控制器中调用模型

在控制器引用模型类

``` php
use App\Models\Users;
```

模型的基本使用语法与 **查询构造器** 语法一致。

``` php
<?php

//查询表中所有数据
Users::select();

//条件查询
Users::where('id', '=', 7)->select();

//插入数据
Users::insert(['name' => 'zereri', 'age' => 0]);
```

更多使用方法请参考 **查询构造器** 。

---

### 关联模型

模型的关联采用**规则制**，定义的关联规则可在多种关联方式同时使用。



##### 规则的定义

``` php
<?php
  //rules_name 为规则名，可自定义
  protected $rules_name = [
      "Relate_Model_1" => ["foreign_key", "Self_key"],
      "Relate_Model_2" => ["foreign_key", "Self_key"]
  ];
```



##### 一对一



<u>现有Users 和 Age 两个model， 要将Users 关联Age 查询用户的年龄。</u>

- 先在Users模型中定义规则。

``` php
<?php
namespace App\Models;

class Users extends Model
{
  	protected $test = [
  		"Age" => ["Age.uid", "Users.id"]
	];
}
```

- 控制器中调用：

``` php
<?php
//test对应是Users的规则名
Users::hasOne("test")->select();
```



##### 一对多

<u>现有Teacher 和 Student 两个model， 要将Teacher 关联Student 查询老师教哪些学生。</u>

- Teacher模型中定义规则

``` php
<?php
namespace App\Models;

class Teacher extends Model
{
  	protected $student_list = [
  		"Student" => ["Student.tid", "Teacher.id"]
	];
}
```

- 控制器中调用：

``` php
<?php
//查询id为22老师的学生名单
Teacher::hasMany("student_list")->where('teacher.id', '=', 22)->select();
```



##### 多对多

 <u>角色表、权限表以及角色—权限表，实现多对多关联</u>

模型：Roles 、 Permissions 、 Role_Permission

- 定义规则

``` php
<?php
namespace App\Models;

class Roles extends Model
{
	protected $rbac = [
        "Role_Permission" => ["Role_Permission.role_id", "Roles.id"],
        "Permissions"     => ["Permissions.id", "Role_Permission.permission_id"]
    ];
}
```

- 控制器中调用：

``` php
<?php
//查询roles表中admin角色拥有的权限
Roles::belongsToMany("rbac")->where('roles.name', '=', 'admin')->select();
```



