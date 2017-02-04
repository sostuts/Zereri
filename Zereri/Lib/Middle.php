<?php
namespace Zereri\Lib;

class Middle
{
    public static function call($before_after_function, $middlewares)
    {
        foreach ($middlewares as $each_middleware_name) {
            if (empty($each_middleware_name)) {
                continue;
            }
            
            if (FALSE === self::callMiddle($before_after_function, $each_middleware_name)) {
                die;
            }
        }
    }


    protected static function callMiddle($before_after, $name)
    {
        $name = '\App\Middles\\' . $name;

        return (new $name)->{$before_after}(Register::get("data"));
    }
}