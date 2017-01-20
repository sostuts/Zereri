# 路由

### 配置文件

- 路径：/App/Config/route.php


- 规则：

``` php
<?php

return [
    "URL"  => [
        "Method"  => "Controller@Function",
        "Method2" => "Controller2@Function2"
    ],
    "URL2" => [
        "Method3" => "Controller3@Function3",
        "Method4" => "Controller4@Function4"
    ]
];
```

<br/>

### 编写GET路由

``` php
<?php

return [
    "/user" => [
        "GET"  => "User@getList"
    ]
];
```

- /user 表示访问 http://YourDomain/user 。
- GET   表示Get方法访问该接口。
- User@getList  表示访问的是 `/App/Controllers/User.php` 中的 `getList` 方法。

##### 控制器  /App/Controllers/User.php

``` php
<?php
namespace App\Controllers;

class User
{
    public function getList()
    {
        echo "hello";
    }
}
```

- **Get方法**访问http://YourDomain/user  将会返回 `hello` 。

<br/>

### 编写多重路由

``` php
<?php

return [
    "/user" => [
        "GET"  	  =>  "User@getList",
      	"DELETE"  =>  "User@delete"
    ]
];
```

- 如果为 **Get** 方法访问该接口将会**访问 getList** 方法。
- 如果为 **DELETE** 方法访问该接口将会**访问 delete** 方法。

<br/>

### 编写带参数路由

``` php
<?php

return [
    "/user/{id}" => [
        "DELETE" => "Admin/User@delete"
    ]
];
```

##### 控制器  /App/Controllers/Admin/User.php

``` php
<?php
namespace App\Controllers\Admin;

class User
{
    public function delete($id)
    {
        echo $id;
    }
}
```

- **DELETE 方法**访问 http://YourDomain/user/123 返回值 `123` 。

<br/>

### 编写带回调函数路由

``` php
<?php

return [
    "/user/{id}" => [
        "DELETE" => function ($id) {
            echo $id;
        }
    ]
];
```

- **DELETE 方法**访问 http://www.domain.com/user/123 返回值 `123` 。

<br/>

<br/>

### 例子

``` php
<?php

return [
    "/student" => [
        "GET"  => "Student@getList",
        "POST" => "Admin@addStudent"
    ],

    "/user/{id}/name/{nickname}" => [
        "GET" => "Student@getInfo",
        "PUT" => "Admin@changeStudentInfo"
    ]
];
```

- 控制器 /App/Controllers/Student.php

``` php
<?php
namespace App\Controllers;

class Student
{
    public function getList()
    {
        echo "StudentList";
    }

    public function getInfo($id, $nickname)
    {
        echo "ID:" . $id;
        echo "Name:" . $nickname;
    }
}
```

- 控制器 /App/Controllers/Admin.php

``` php
<?php
namespace App\Controllers;

class Admin
{
    public function addStudent()
    {
        echo "This is addStudent";
    }

    public function changeStudentInfo($id, $nickname, $newName)
    {
        echo "ID:" . $id;
        echo "Name:" . $nickname;
      	echo "newName:" . $newName;
    }
}
```

##### 访问

- http://YourDomain/student

> Get访问，返回值：`StudentList`
>
> Post访问，返回值：`This is addStudent`

<br/>

- http://YourDomain/user/123/name/Zereri

> Get访问，返回值：`ID:123 Name:Zereri`
>
> Post带参数**newName=ZZZ**访问，返回值：`ID:123 Name:Zereri newName:ZZZ`

<br/>

<br/>

# 版本控制

### 开启版本控制

- 修改config.php

``` php
'version_control' => true
```

<br/>

### 编写路由

``` php
<?php

return [
    "v1" => [
        "/api/list" => [
            "GET" => "Api@index"
        ],
        "URL"       => [
            "Method" => "Controller@Function"
        ]
    ],

    "v2" => [
        "/api/list" => [
            "GET" => "First@hello"
        ]
    ]
];
```

- 访问 http://YourDomain/v1/api/list 访问 `/App/Controllers/Api.php` 的`index` 方法
- 访问 http://YourDomain/v2/api/list 访问 `/App/Controllers/First.php` 的`hello` 方法