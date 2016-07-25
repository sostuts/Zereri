<?php
namespace Zereri\Lib;

class Middle
{
    /**中间件函数名
     *
     * @var string
     */
    private static $func;


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

        foreach (self::getMethod() as $method) {
            if (!isset($middle[ $method ])) {
                return NULL;
            }

            if (is_array($middle[ $method ])) {
                foreach ($middle[ $method ] as $middle_name) {
                    return self::callMiddle($middle_name);
                }
            } else {
                return self::callMiddle($middle[ $method ]);
            }
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