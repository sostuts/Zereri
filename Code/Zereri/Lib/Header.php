<?php
namespace Zereri\Lib;

class Header
{
    public static function set(array $header)
    {
        foreach ($header as $key => $val) {
            header($key . ':' . $val);
        }
    }
}