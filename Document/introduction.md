## Zereri

#### 前言

Zereri，PHP框架，一个专为**前后端分离**而写的轻量级框架，采用了主流的mvc架构，同时附加了一些实用的功能，让开发项目变得更快速。



#### 环境要求

- PHP >= 5.6
- OpenSSL PHP 扩展
- PDO PHP 扩展
- Mbstring PHP 扩展



#### 目录结构

- App     (项目代码文件)

| 文件夹         | 说明            |
| ----------- | ------------- |
| Config      | 配置文件          |
| Controllers | 控制器文件         |
| Lib         | 自己封装的类库       |
| Models      | 模型文件          |
| Session     | 默认存放session文件 |
| Tpl         | 存放view层模板     |
| Middles     | 中间件类          |
| Queues      | 队列任务类         |

- logs      (日志文件)
- public  (前端文件，如\*.html、\*.css 、*.image)
- tests    (测试文件)
- vendor(Composer扩展)
- Zereri  (框架文件)

------

#### 配置

/App/Config/config.php 文件包含以下配置

| 名称              | 说明        |
| --------------- | --------- |
| log             | 日志记录方式    |
| debug           | 调试模式      |
| version_control | 开启版本控制    |
| https_port      | Https端口   |
| database        | 数据库配置     |
| smarty          | 基本配置      |
| aliases         | 类的别名      |
| cache           | 缓存配置      |
| session         | session配置 |
| status_code     | HTTP返回状态码 |