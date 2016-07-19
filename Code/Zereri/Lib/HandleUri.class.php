<?php
namespace Zereri\Lib;

class HandleUri
{
    //获取的uri
    private $uri;

    //解析出来的控制器类名
    private $class;

    //解析出来的控制器方法名
    private $method;

    //控制器的命名空间
    private $controller_namespace;


    public function __construct()
    {
        $this->uri = $this->getUri();
        $this->controller_namespace = '\App\Controllers\\';
        $this->explodeUri();
    }


    /**获取Uri
     *
     * @return string
     */
    private function getUri()
    {
        return urldecode($_SERVER['REQUEST_URI']);
    }


    /**分解URI取最后两个数据得类名以及方法名
     *
     * @throws \Zereri\Lib\UserException
     */
    private function explodeUri()
    {
        $class_and_method = explode('/', $this->uri);
        if (count($class_and_method) < 2) {
            throw new UserException('Wrong Url!');
        }
        list($this->class, $this->method) = array_slice($class_and_method, -2);
    }


    /**获取控制器类名
     *
     * @return string
     */
    public function getClass()
    {
        return $this->controller_namespace . $this->class;
    }


    /**获取控制器方法
     *
     * @return string
     */
    public function getMethod()
    {
        return $this->method;
    }
}