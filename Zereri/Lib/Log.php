<?php
namespace Zereri\Lib;

class Log
{
    public static function mark($content)
    {
        $file = __LOG__;
        $type = 3;
        $content = self::getIntegrateContent($content);
        error_log($content, $type, $file);
    }


    protected static function getIntegrateContent($content)
    {
        return '[' . date('Y-m-d H:i:s') . ']  ' . $content . "\n\n";
    }
}