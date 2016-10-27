<?php
return [
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
        'cluster' => FALSE,
        'auth'    => NULL,
        'server'  => ["127.0.0.1", 6379]
    ]
];