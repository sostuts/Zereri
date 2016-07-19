<?php
namespace Zereri\Lib;

use ReflectionMethod;
use Zereri\Lib\UserException;

class CallController
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
            throw new UserException('The Method does not exist!');
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


    /**设置对应控制器方法的参数
     *
     * @return \Generator
     * @throws \Zereri\Lib\UserException
     */
    private function setControllerParams()
    {
        foreach ($this->reflect->getParameters() as $param) {
            $this->params[] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : $this->getPostColmn($param->getName());
        }
    }


    /**获取Post里的指定字段内容
     *
     * @param $param_name
     *
     * @return mixed
     * @throws \Zereri\Lib\UserException
     */
    private function getPostColmn($param_name)
    {
        if (!isset($this->post[ $param_name ])) {
            throw new UserException('Post content does not have the   "' . $param_name . '"   of the colmn.');
        }

        return $this->post[ $param_name ];
    }


    /**
     * 调用控制器方法
     */
    public function call()
    {
        (new $this->class)->{$this->method}(...$this->params);
    }
}