<?php
namespace Zereri\Lib;

class Register
{
    /**对象实例
     *
     * @var array
     */
    protected static $instance;


    /**获取指定对象
     *
     * @param $name
     *
     * @return mixed
     */
    public static function get($name)
    {
        return isset(self::$instance[ $name ]) ? self::$instance[ $name ] : "";
    }


    /**存放对象
     *
     * @param $name
     * @param $value
     */
    public static function set($name, $value)
    {
        self::$instance[ $name ] = $value;
    }


    /**销毁指定对象
     *
     * @param $name
     */
    public static function _unset($name)
    {
        unset(self::$instance[ $name ]);
    }

}