# 目录

### Zereri

- [基本介绍](https://github.com/sostuts/Zereri/blob/development/Document/introduction.md)
- [访问机制](https://github.com/sostuts/Zereri/blob/development/Document/visit.md)



### 核心

- [路由器](https://github.com/sostuts/Zereri/blob/development/Document/route.md)
- [控制器](https://github.com/sostuts/Zereri/blob/development/Document/controller.md)
- [中间件](https://github.com/sostuts/Zereri/blob/development/Document/middleware.md)
- [查询构造器](https://github.com/sostuts/Zereri/blob/development/Document/db.md)
- [关联模型](https://github.com/sostuts/Zereri/blob/development/Document/model.md)



### 服务

- [Api文档生成](https://github.com/sostuts/Zereri/blob/development/Document/api.md)
- [缓存](https://github.com/sostuts/Zereri/blob/development/Document/cache.md)
- [Session](https://github.com/sostuts/Zereri/blob/development/Document/session.md)
- [测试](https://github.com/sostuts/Zereri/blob/development/Document/test.md)
- [队列](https://github.com/sostuts/Zereri/blob/development/Document/queue.md)


### Demo

- [用户登录](./Document/demo_login.md)
- [文件上传](./Document/demo_upload.md)
- [富文本](./Document/demo_editor.md)

<br/>

<br/>

# 常见疑问

### 为什么显示Permission denied？ 怎么解决？

    如题，错误原因是没有给予足够的权限给web服务，框架有些机制会产生一些写操作，如果没有写的权限将会显示该错误。

    解决方案：给对应的目录添加写的权限。一般来说框架仅在 `/Zereri/Lib/Indexes` 、`/App/FileCache` 、`/App/Session`  、 `/App/Smarty` 、`/logs` 五个目录有写操作。

