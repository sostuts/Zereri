# 目录

### Zereri

- [基本介绍](./Document/introduction.md)
- [访问机制](./Document/visit.md)



### 核心

- [路由器](./Document/route.md)
- [控制器](./Document/controller.md)
- [中间件](./Document/middleware.md)
- [查询构造器](./Document/db.md)
- [关联模型](./Document/model.md)



### 服务

- [Api文档生成](./Document/api.md)
- [缓存](./Document/cache.md)
- [Session](./Document/session.md)
- [测试](./Document/test.md)
- [队列](./Document/queue.md)


### Demo

- [用户登录](./Document/demo_login.md)
- [文件上传](./Document/demo_upload.md)
- [富文本](./Document/demo_editor.md)

<br/>

# 常见疑问

### 为什么第一次访问页面没有内容？或者显示Permission denied？ 怎么解决？

    如题，出现错误的原因可能是没有给予足够的权限给web服务，框架有些机制会产生一些写操作，如果没有写的权限将会显示该错误。

    解决方案：给对应的目录添加写的权限(若目录所有者为root则:  `sudo chmod -R 777 /Path/Dir  ` ，后续生成的文件权限644)。一般来说框架仅在 `/Zereri/Lib/Indexes` 、`/App/FileCache` 、`/App/Session`  、 `/App/Smarty` 、`/logs` 五个目录有写操作，请一一添加写权限。

<br/>

# 联系方式

    若您发现什么问题(如:BUG)或有什么疑问，请提交Issue或 Email: me@zeffee.com。