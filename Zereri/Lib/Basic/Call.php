<?php
namespace Zereri\Lib\Basic;

use ReflectionMethod;
use Zereri\Lib\UserException;
use Zereri\Lib\Middle;

class Call
{
    /**控制器的类名
     *
     * @var string
     */
    private $class;


    /**控制器的方法名
     *
     * @var string
     */
    private $method;


    /**控制器关联的中间件
     *
     * @var array
     */
    private $middlewares;


    /**post数据内容
     *
     * @var string
     */
    private $post;


    /**url中的参数
     *
     * @var array
     */
    private $url_params;


    /**控制器方法的参数
     *
     * @var array
     */
    private $controller_params_value;


    /**回调函数
     *
     * @var callable
     */
    private $callback;


    public function __construct($class, $method, $url_params = [], $middlewares, $callback)
    {
        $this->class = $class;
        $this->method = $method;
        $this->url_params = $url_params;
        $this->middlewares = $middlewares;
        $this->callback = $callback;
    }


    public function setPostData($post)
    {
        if (!$this->callback) {
            $this->post = $post;
            $this->controller_params_value = $this->getControllerParamsValueFromUrlParams();
        }

        return $this;
    }


    private function getControllerParamsValueFromUrlParams()
    {
        $controller_params = $this->getReflect()->getParameters();
        $controller_params_value = [];
        $url_params_array_length = count($this->url_params);

        foreach ($controller_params as $index => $param) {
            if ($index < $url_params_array_length) {
                $controller_params_value[] = urldecode($this->url_params[ $index ]);

                continue;
            }

            $controller_params_value[] = $this->getPostParamValue($param->getName()) ?: $this->getDefaultValue($param);
        }

        return $controller_params_value;
    }


    private function getReflect()
    {
        if (!$this->isMethodExists()) {
            throw new UserException('The Api does not exist!');
        }

        return new ReflectionMethod($this->class, $this->method);
    }


    private function isMethodExists()
    {
        return method_exists($this->class, $this->method);
    }


    private function getPostParamValue($param_name)
    {
        if (!isset($this->post[ $param_name ])) {
            return false;
        }

        return $this->post[ $param_name ];
    }


    private function getDefaultValue(&$param)
    {
        return $param->isDefaultValueAvailable() ? $param->getDefaultValue() : $this->throwParamNeedException($param->getName());
    }


    private function throwParamNeedException($param_name)
    {
        throw new UserException('It requires a parameter <b>"' . $param_name . '"</b>.');
    }


    /**
     * 调用回调函数 或者 中间件以及控制器
     */
    public function call()
    {
        if ($this->callback) {
            call_user_func_array($this->callback, $this->url_params);

            return false;
        }

        if ($this->middlewares) {
            $this->callBeforeMiddle()->callController()->callAfterMiddle();
        } else {
            $this->callController();
        }
    }


    /**调用控制器
     *
     * @return $this
     */
    private function callController()
    {
        (new $this->class)->{$this->method}(...$this->controller_params_value);

        return $this;
    }


    /**调用前置中间件
     *
     * @return $this
     */
    private function callBeforeMiddle()
    {
        Middle::call("before", $this->middlewares);

        return $this;
    }


    /**
     * 调用后置中间件
     */
    private function callAfterMiddle()
    {
        Middle::call("after", $this->middlewares);
    }
}