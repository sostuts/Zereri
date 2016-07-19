<?php
namespace Zereri\Lib\Replacement;

class Common
{
    public static function __callStatic($func, $arguments)
    {
        $class_name = static::getClassName();

        return (new $class_name)->{$func}(...$arguments);
    }
}
