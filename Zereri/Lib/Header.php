<?php
namespace Zereri\Lib;

class Header
{
    public static function set($header)
    {
        if (is_array($header)) {
            foreach ($header as $key => $val) {
                if (is_numeric($key)) {
                    header($val);

                    continue;
                }

                header($key . ':' . (is_array($val) ? implode(",", $val) : $val));
            }
        } else {
            header($header);
        }
    }
}