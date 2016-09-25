<?php
namespace Zereri\Lib;

class HandleUri
{
    //解析出来的控制器类名
    private $class;

    //解析出来的控制器方法名
    private $method;

    //url参数
    private $params;

    //控制器的命名空间
    private $controller_namespace;


    public function __construct()
    {
        list($this->class, $this->method) = $this->explodeUrl();
        $this->controller_namespace = '\App\Controllers\\';
    }


    /**获取Uri
     *
     * @return string
     */
    private function getUrl()
    {
        return urldecode($_SERVER['QUERY_STRING']);
    }


    /**分解url
     *
     * @return array
     */
    private function explodeUrl()
    {
        $url = "/" . $this->getUrl();
        if ($this->isRouteExist($url)) {
            return $this->getReturnClassMethod($url);
        } elseif (($route = $this->matchParam($url)) && $this->isRouteExist($route)) {
            return $this->getReturnClassMethod($route);
        } else {
            response(404, "", "text", "", 1);
        }
    }


    /**判断路由是否存在
     *
     * @return bool
     */
    private function isRouteExist($route)
    {
        if (!isset($GLOBALS["route"][ $route ][ $_SERVER['REQUEST_METHOD'] ])) {
            return false;
        }

        return true;
    }


    /**从url中提取控制器以及方法
     *
     * @param $route
     *
     * @return array
     */
    private function getReturnClassMethod($route)
    {
        $class_method = preg_replace('/\\//', '\\', $GLOBALS["route"][ $route ][ $_SERVER['REQUEST_METHOD'] ]);

        return explode("@", $class_method);
    }


    /**获取url中的参数
     *
     * @param $url
     *
     * @return bool
     */
    private function matchParam($url)
    {
        $routes = array_keys($GLOBALS["route"]);
        foreach ($routes as $each_route) {
            if ($rule = preg_replace('/\\{.*\\}/Usm', '([^\\/]*)', $each_route)) {
                if (preg_match('#^' . $rule . '$#', $url, $param)) {
                    $this->params = array_slice($param, 1);

                    return $each_route;
                }
            }
        }

        return false;
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


    /**获取控制器url参数
     *
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
    }
}