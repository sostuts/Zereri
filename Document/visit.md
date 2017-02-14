# 访问机制

### 准备工作

- 将服务器的web服务 **根目录** 指向 **/public/**   。

- **apache**开启 `mod_rewrite` 模块，支持 **.htaccess**文件 。

- **nginx** 添加以下配置：

  ``` 
  location / {
      try_files $uri $uri/ /index.php?$query_string;
  }
  ```


<br/>

### 访问前端文件

- 格式：`http://domain/PATH/FILE`

如：/public/  文件夹里面有  index.html

URL: http://YourDomain/   or  http://YourDomain/index.html  

如：/public/a.html

URL:http://YourDomain/a.html

<br/>

### 访问控制器

- 编写控制器(请看**控制器**文档)

如：/App/Controllers/Hello.php

```php
<?php
namespace App\Controllers;

class Hello
{
    public function welcome()
    {
        response(200, "Welcome, i am Zereri !");
    }
}
```

- 编写路由器(请看**路由器**文档)

如：/App/Config/route.php

```php
<?php

return [
    "/test" => [
        "GET" => "Hello@welcome"
    ]
];
```

- **访问服务器**

input: http://YourDomain/test

result: `Welcome, i am Zereri !`

(若打开为空白页或提示Permission denied 请参考[常见疑问](../README.md#常见疑问))

