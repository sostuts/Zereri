<?php
/**
 * 获取全局配置
 */
$GLOBALS['config'] = require_once __ROOT__ . '/Zereri/Config/config.php';
$GLOBALS['user_config'] = array_merge(require_once __ROOT__ . '/App/Config/config.php', require_once __ROOT__ . '/App/Config/cache.php', require_once __ROOT__ . '/App/Config/database.php');
$GLOBALS['user_config']['route'] = require_once __ROOT__ . "/App/Config/route.php";

/**
 * 日志配置
 */
define('__LOG__', $GLOBALS['config']['log'][ $GLOBALS['user_config']['log'] ]);
ini_set('display_errors', 0);               //不显示错误信息
ini_set('error_log', __LOG__);              //日志文件位置
ini_set('log_errors', 1);                   //开启错误日志记录

/**
 * 跨域设置
 */
\Zereri\Lib\Header::set([
    "Access-Control-Allow-Origin"      => $GLOBALS['user_config']['origin'],
    "Access-Control-Allow-Methods"     => "*",
    "Access-Control-Allow-Credentials" => "true",
    "Access-Control-Allow-Headers"     => $GLOBALS['user_config']['headers']
]);