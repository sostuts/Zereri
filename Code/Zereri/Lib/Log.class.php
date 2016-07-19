<?php
namespace Zereri\Lib;

class Log
{
    private static $env = [
        'file'    => '',
        'type'    => '',
        'content' => ''
    ];

    public static function mark($content)
    {
        self::construct($content);

        self::markLog();
    }

    protected static function construct($content)
    {
        self::$env['file'] = __LOG__;
        self::$env['type'] = 3;
        self::$env['content'] = '[' . date('Y-m-d H:i:s') . ']  ' . $content . "\n\n";
    }

    protected static function markLog()
    {
        error_log(self::$env['content'], self::$env['type'], self::$env['file']);
    }

}