<?php
namespace Zereri\Lib\Basic;


class Call_Info
{
    /**将要调用的控制器类名
     *
     * @var string
     */
    private $class;


    /**将要调用的控制器方法
     *
     * @var string
     */
    private $method;


    /**用户请求的url参数值
     *
     * @var array
     */
    private $url_params;


    /**将要调用的控制器关联的中间件
     *
     * @var array
     */
    private $middlewares;


    /**将要调用的回调函数
     *
     * @var callable
     */
    private $callback;


    public function __construct()
    {
        if ($this->isOptionsHttpRequestMethod()) {
            response(200);
        } else {
            $this->init();
        }
    }


    private function isOptionsHttpRequestMethod()
    {
        return ($_SERVER['REQUEST_METHOD'] === "OPTIONS");
    }


    private function init()
    {
        list($version, $url_route) = HandleUrl::getVersionAndRouteFromUrl();

        list($request_config_route, $this->url_params) = Route::getConfigRoute_UrlParamsFromTreatedRoute($version, $url_route);

        list($this->class, $this->method, $this->middlewares, $this->callback) = Controller_Info::getControllerInfoByRequestConfigRoute($version, $request_config_route);
    }


    public function getClass()
    {
        $controller_namespace = '\App\Controllers\\';

        return $controller_namespace . $this->class;
    }


    public function getMethod()
    {
        return $this->method;
    }


    public function getUrlParams()
    {
        return $this->url_params;
    }


    public function getMiddleWares()
    {
        return $this->middlewares;
    }


    public function getCallBack()
    {
        return $this->callback;
    }
}