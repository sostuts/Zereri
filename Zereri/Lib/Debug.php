<?php
namespace Zereri\Lib;

use Zereri\Lib\Replacement\Smarty;

class Debug
{
    /**是否为调试模式
     *
     * @return bool
     */
    public static function isDebug()
    {
        return ($GLOBALS['user_config']['debug'] === true);
    }


    /**输出错误信息
     *
     * @param $err_content
     */
    public static function outputError($err_content)
    {
        if (self::isDebug()) {
            self::echoErrorMsg($err_content);
        } else {
            self::echoErrorMsg();
        }

        die();
    }


    /**get || post
     *
     * @param string $err_content
     */
    protected static function echoErrorMsg($err_content = "")
    {
        if ("POST" === $_SERVER['REQUEST_METHOD']) {
            print_r("Something Wrong! " . $err_content);
        } else {
            self::loadErrorHtml($err_content);
        }
    }


    /**加载错误页面
     *
     * @param string $err_content
     */
    protected static function loadErrorHtml($err_content)
    {
        Smarty::load("error.html", ["content" => $err_content]);
    }
}