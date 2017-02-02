<?php
namespace Zereri\Lib;

use Zereri\Lib\Replacement\Smarty;
use Zereri\Lib\Basic\Request;

class Debug
{
    public static function isDebug()
    {
        return config("debug");
    }


    public static function outputError($err_content)
    {
        if (self::isDebug()) {
            self::echoErrorMsg($err_content);
        } else {
            self::echoErrorMsg();
        }

        die();
    }


    protected static function echoErrorMsg($err_content = "")
    {
        if (Request::isPost_Put_Patch()) {
            print_r("Something Wrong! " . $err_content);
        } else {
            self::loadErrorHtml($err_content);
        }
    }


    protected static function loadErrorHtml($err_content)
    {
        Smarty::load("error.html", ["content" => $err_content]);
    }
}