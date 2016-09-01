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
        'master' => [
        ],

        //若无从库则 'slave' => []
        'slave'  => [
        ]
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
        'Api'                     => Zereri\Lib\Replacement\Api::class,
        'Factory'                 => Zereri\Lib\Factory::class,
        'App\Models\Model'        => Zereri\Lib\Model::class,
        'App\Queues\InQueue'      => Zereri\Lib\InQueue::class,
        'App\Middles\MiddleWare'  => Zereri\Lib\MiddleWare::class,
        'App\Controllers\Smarty'  => Zereri\Lib\Replacement\Smarty::class,
        'App\Controllers\Session' => Zereri\Lib\Replacement\Session::class,
        'App\Controllers\Cache'   => Zereri\Lib\Replacement\Cache::class
    ],


    /**
     * 缓存配置
     */
    'cache'     => [
        "drive" => "redis",
        'time'  => 3600
    ],


    /**
     * Memcached服务器配置
     */
    'memcached' => [
        'server' => [
            ['127.0.0.1', 11211]
        ]
    ],


    /**
     * redis服务器配置
     */
    'redis'     => [
        'server' => ["127.0.0.1", 6379]
    ],


    /**
     *      Session
     * --------------------
     *   file || memcached || redis
     */
    'session'   => [
        'drive' => 'file'
    ]

];