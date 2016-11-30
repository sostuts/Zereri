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

    //回调函数
    private $callback;

    //控制器的命名空间
    private $controller_namespace;


    public function __construct()
    {
        if ($this->isOptionsMethod()) {
            response(200);
        }

        $this->init();
    }


    private function isOptionsMethod()
    {
        return ($_SERVER['REQUEST_METHOD'] === "OPTIONS");
    }


    private function init()
    {
        $this->controller_namespace = '\App\Controllers\\';
        list($this->version, $this->url) = $this->getVersionAndUrl();
        $this->url = "/" . $this->url;
        list($this->class, $this->method, $this->callback) = $this->explodeUrl();
    }


    /**获取请求版本以及url地址
     *
     * @return array
     */
    private function getVersionAndUrl()
    {
        $url = $_SERVER['QUERY_STRING'] ?: substr($_SERVER["REQUEST_URI"], 1);
        if (!config("version_control")) {
            return ["", $url];
        }

        if (count($pieces = explode("/", $url, 2)) > 1) {
            return $pieces;
        }

        return ["", ""];
    }


    /**分解url
     *
     * @return array
     */
    private function explodeUrl()
    {
        if ($this->isRouteExist($this->url)) {
            return $this->callbackOrGetClassMethod($this->url);
        } elseif (($route = $this->matchParam($this->url)) && $this->isRouteExist($route)) {
            return $this->callbackOrGetClassMethod($route);
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


    /**从路由中提取控制器、方法名以及回调函数
     *
     * @param $route
     *
     * @return array
     */
    private function callbackOrGetClassMethod($route)
    {
        $route =& $this->getRouteSelf($route);

        //回调
        if (is_callable($route)) {
            return ["", "", $route];
        }

        $class_method = explode("@", preg_replace('/\\//', '\\', $route));
        array_push($class_method, NULL);

        return $class_method;
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


    /**获取路由的回调函数
     *
     * @return mixed
     */
    public function getCallback()
    {
        return $this->callback;
    }
}