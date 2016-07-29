<?php
namespace Zereri\Lib;

class Middle
{
    /**中间件函数名
     *
     * @var string
     */
    private static $func;


    /**控制器的中间件列表
     *
     * @var array
     */
    private static $middle;


    /**调用中间件
     *
     * @param $func
     * @param $middle
     *
     * @return mixed
     */
    public static function call($func, &$middle)
    {
        self::$func = $func;
        self::$middle =& $middle;

        return self::callMethodMiddles();
    }


    /**调用与该方法关联的所有中间件
     *
     * @return mixed|null
     */
    protected static function callMethodMiddles()
    {
        foreach (self::getMethod() as $method) {
            if (!isset(self::$middle[ $method ])) {
                return NULL;
            }

            return self::callMethodEachMiddle($method);
        }
    }


    /**调用每个中间件
     *
     * @param $method
     *
     * @return mixed
     */
    protected static function callMethodEachMiddle($method)
    {
        if (is_array(self::$middle[ $method ])) {
            foreach (self::$middle[ $method ] as $middle_name) {
                return self::callMiddle($middle_name);
            }
        } else {
            return self::callMiddle(self::$middle[ $method ]);
        }
    }


    /**获取被调用的函数名
     *
     * @return array
     */
    protected static function getMethod()
    {
        return ["all", Register::get("method")];
    }


    /**实例化中间件
     *
     * @param $name
     *
     * @return mixed
     */
    protected static function callMiddle($name)
    {
        $name = '\App\Middles\\' . $name;

        return (new $name)->{self::$func}(Register::get("data"));
    }
}