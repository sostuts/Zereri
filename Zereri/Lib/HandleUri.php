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


    /**分解URI取最后两个数据得类名、方法名和get参数
     *
     * @throws UserException
     */
    private function explodeUri()
    {
        $class_and_method = explode('/', $this->uri);
        if (($count = count($class_and_method)) < 2) {
            throw new UserException('Wrong Url!');
        }

        $method_get = explode("?", $class_and_method[ $count - 1 ], 2);
        if (isset($method_get[1])) {
            parse_str($method_get[1], $_GET);
        }
        $this->method = $method_get[0];
        $this->class = $class_and_method[ $count - 2 ];
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