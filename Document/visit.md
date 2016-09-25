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

<br/>

### 访问控制器

- 编写路由规则，请参考 **路由** 文档。
- 编写控制器， 请参考 **控制器** 文档。