# Zereri

### 前言

    Zereri，PHP框架，一个适用但不仅限于**开发后端接口**的轻量级框架，采用了主流的mvc架构，同时附加了一些实用的功能，让项目的开发变得更便捷。

<br/>

### 环境要求

- PHP >= 5.6
- OpenSSL PHP 扩展
- PDO PHP 扩展
- Mbstring PHP 扩展


<br/>

### 安装

- 直接在[Github Releases](https://github.com/sostuts/Zereri/releases)下载最新版。
- Composer 安装:

```bash
composer create-project zereri/zereri Your-Project-Name
```

<br/>

### 目录结构

```bash
Zereri-1.0
├── App
│   ├── Config			 # 配置文件
│   ├── Controllers	      # 控制器文件
│   ├── FileCach   	   	  # 缓存文件
│   ├── Lib			     # 自己封装的类
│   ├── Middles			 # 中间件类
│   ├── Models 	  		 # 模型文件
│   ├── Queues 	   		 # 队列任务类
│   ├── Session	 	   	 # 存放session文件
│   ├── Smarty 	   	  	 # 模板引擎配置、编译文件
│   └── Tpl				# 存放view层模板
│
├── logs	  			# 日志文件
├── publi	 			# 前端文件，如*.html、*.css 、*.image
├── tests  				# 测试文件
├── vendor 	  			# Composer扩展
└── Zereri			   	# 框架文件
```

<br/>

------

### 配置

- /App/Config/config.php 文件包含以下配置

| 名称              | 说明               |
| --------------- | ---------------- |
| log             | 日志记录方式           |
| debug           | 调试模式             |
| version_control | 路由版本控制           |
| https_port      | 程序的HTTPS端口       |
| smarty          | 基本配置             |
| aliases         | 类的别名             |
| session         | session配置        |
| origin          | 允许跨域的源地址，默认为允许全部 |
| headers         | 允许携带的HTTP头部字段名   |
| status_code     | HTTP返回状态码        |

- /App/Config/cache.php 文件包含缓存的配置，具体介绍请在**缓存**文档查看。
- /App/Config/database.php 文件包含数据库的配置，具体介绍请在**查询构造器**文档查看。
- /App/Config/route.php 文件包含路由规则，具体介绍请在**路由器**文档查看。

