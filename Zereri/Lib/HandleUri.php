<?php
namespace Zereri\Lib;

class HandleUri
{
    //请求的url(不包含版本)
    private $url;

    //解析出来的控制器类名
    private $class;

    //解析出来的控制器方法名
    private $method;

    //请求的版本
    private $version;

    //url参数
    private $params;

    //控制器的命名空间
    private $controller_namespace;


    public function __construct()
    {
        $this->controller_namespace = '\App\Controllers\\';
        list($this->version, $this->url) = $this->getVersionAndUrl();
        $this->url = "/" . $this->url;
        list($this->class, $this->method) = $this->explodeUrl();
    }


    /**获取请求版本以及url地址
     *
     * @return string
     */
    private function getVersionAndUrl()
    {
        $url = urldecode($_SERVER['QUERY_STRING']);
        if (!config("version_control")) {
            return ["", $url];
        }

        return explode("/", $url, 2);
    }


    /**分解url
     *
     * @return array
     */
    private function explodeUrl()
    {
        if ($this->isRouteExist($this->url)) {
            return $this->getReturnClassMethod($this->url);
        } elseif (($route = $this->matchParam($this->url)) && $this->isRouteExist($route)) {
            return $this->getReturnClassMethod($route);
        } else {
            response(404, "", "text", "", 1);
        }
    }


    /**判断路由是否存在
     *
     * @param $route
     *
     * @return bool
     */
    private function isRouteExist($route)
    {
        $route =& $this->getRouteSelf($route);
        if (!isset($route)) {
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
        $route =& $this->getRouteSelf($route);
        $class_method = preg_replace('/\\//', '\\', $route);

        return explode("@", $class_method);
    }


    /**获取route引用
     *
     * @param $route
     *
     * @return mixed
     */
    private function &getRouteSelf($route)
    {
        if ($this->version) {
            return $GLOBALS["route"][ $this->version ][ $route ][ $_SERVER['REQUEST_METHOD'] ];
        }

        return $GLOBALS["route"][ $route ][ $_SERVER['REQUEST_METHOD'] ];
    }


    /**获取url中的参数
     *
     * @param $url
     *
     * @return bool
     */
    private function matchParam($url)
    {
        $routes = array_keys($this->version ? $GLOBALS["route"][ $this->version ] : $GLOBALS["route"]);
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