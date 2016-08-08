<?php
namespace Zereri\Lib;

use ReflectionMethod;
use Zereri\Lib\UserException;

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


    /**控制器的反射对象
     *
     * @var ReflectionMethod
     */
    private $reflect;


    /**post数据内容
     *
     * @var string
     */
    private $post;


    /**控制器方法的参数
     *
     * @var array
     */
    private $params = [];


    /**控制器实例
     *
     * @var Object
     */
    private $controller;


    public function __construct($class, $method)
    {
        $this->class = $class;
        $this->method = $method;
        $this->reflect = $this->getReflect();
    }


    /**获取控制器反射对象
     *
     * @return ReflectionMethod
     * @throws \Zereri\Lib\UserException
     */
    private function getReflect()
    {
        if (!$this->isMethodExists()) {
            throw new UserException('The Api does not exist!');
        }

        return new ReflectionMethod($this->class, $this->method);
    }


    /**方法是否存在
     *
     * @return bool
     */
    private function isMethodExists()
    {
        return method_exists($this->class, $this->method);
    }


    /**设置post内容
     *
     * @param $post
     *
     * @return $this
     */
    public function setPost($post)
    {
        $this->post = $post;
        $this->setControllerParams();

        return $this;
    }


    /**
     * 设置对应控制器方法的参数
     */
    private function setControllerParams()
    {
        foreach ($this->reflect->getParameters() as $param) {
            $this->params[] = $this->getPostColmn($param->getName()) ?: $this->getDefaultValue($param);
        }
    }


    /**获取Post里的指定字段内容
     *
     * @param $param_name
     *
     * @return bool
     */
    private function getPostColmn($param_name)
    {
        if (!isset($this->post[ $param_name ])) {
            return false;
        }

        return $this->post[ $param_name ];
    }


    /**获取参数默认值
     *
     * @param $param
     *
     * @throws \Zereri\Lib\UserException
     */
    private function getDefaultValue(&$param)
    {
        return $param->isDefaultValueAvailable() ? $param->getDefaultValue() : $this->valueError($param->getName());
    }


    /**字段无值抛出异常
     *
     * @param $param_name
     *
     * @throws \Zereri\Lib\UserException
     */
    private function valueError($param_name)
    {
        throw new UserException('Post data must have the colmn <b>"' . $param_name . '"</b>.');
    }


    /**
     * 调用中间件以及控制器
     */
    public function call()
    {
        $this->controller = new $this->class;

        if (isset($this->controller->middle)) {
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
        $this->controller->{$this->method}(...$this->params);

        return $this;
    }


    /**调用前置中间件
     *
     * @return $this
     */
    private function callBeforeMiddle()
    {
        if (FALSE === Middle::call("before", $this->controller->middle)) {
            die();
        }

        return $this;
    }


    /**
     * 调用后置中间件
     */
    private function callAfterMiddle()
    {
        Middle::call("after", $this->controller->middle);
    }
}