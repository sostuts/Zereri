# 常见疑问

### 为什么显示Permission denied？ 怎么解决？

​	如题，错误原因是没有给予足够的权限给web服务，框架有些机制会产生一些写操作，如果没有写的权限将会显示该错误。

​	解决办法：给对应的目录添加写的权限。一般来说框架仅在 `/Zereri/Lib/Indexes` 、`/App/FileCache` 、`/App/Session`  、 `/App/Smarty` 、`/logs` 五个目录有写操作。

​	