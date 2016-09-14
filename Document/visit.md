# 访问机制

### 准备工作

- 服务器的web服务**根目录**指向**/public/**   。
  
- **apache**开启 `mod_rewrite` 模块，支持 **.htaccess**文件 。
  
- **nginx** 添加以下配置：
  
  ``` 
  location / {
      try_files $uri $uri/ /index.php?$query_string;
  }
  ```
  
  ​

### 访问前端文件

- 格式：`http://domain/PATH/FILE`

如：/public/  文件夹里面有  index.html ,  a.html

URL: http://www.example.com/   、 http://www.example.com/a.html



### 访问控制器

- 格式：`http://domain/Class/method`

如：/App/Controllers/ 文件夹里面有 Test.php ，存在**today**方法。

URL: http://www.example.com/Test/today



### Get传参至控制器

- 格式：`http://domain/Class/method?param1=hello&param2=world`

如：传值为2016的year参数至 **Test/today**。

URL: http://www.example.com/Test/today?year=2016