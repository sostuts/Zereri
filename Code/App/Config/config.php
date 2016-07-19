<?php

return [
    /*
     *    日志记录方式
     * -----------------
     *  single || daily
     */
    'log'       => 'single',


    /*
     *     调试模式
     * ----------------
     *  true || false
     */
    'debug'     => true,


    /**
     * 数据库配置
     */
    'database'  => [
        "drive"  => "mysql",
        "host"   => "localhost",
        "dbname" => "zereri",
        "user"   => "root",
        "pwd"    => "root"
    ],


    /**
     * Smarty配置
     */
    'smarty'    => [
        "debugging"       => false,
        "caching"         => false,
        "cache_lifetime"  => 120,
        "left_delimiter"  => "<{",
        "right_delimiter" => "}>"
    ],


    /**
     * 类名别名
     */
    'aliases'   => [
        'Request'                  => Zereri\Lib\Request::class,
        'HandleUri'                => Zereri\Lib\HandleUri::class,
        'CallController'           => Zereri\Lib\CallController::class,
        'App\Controllers\Smarty'   => Zereri\Lib\Replacement\Smarty::class,
        'App\Controllers\Session'  => Zereri\Lib\Replacement\Session::class,
        'Api'                      => Zereri\Lib\Replacement\Api::class,
        'App\Controllers\Memcache' => Zereri\Lib\Replacement\Memcache::class,
        'App\Models\Model'         => Zereri\Lib\Model::class
    ],


    /**
     * Memcached默认配置
     */
    'memcached' => [
        'time'   => 3600,
        'server' => [
            ['127.0.0.1', 11211]
        ]
    ],


    /**
     *      Session
     * --------------------
     *   file || memcached
     */
    'session'   => [
        'drive' => 'file'
    ]

];