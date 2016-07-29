<?php
namespace Zereri\Lib;

use Exception;

class UserException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = NULL)
    {
        parent::__construct($message, $code, $previous);
    }


    /**
     * 捕捉异常
     */
    public static function catchException()
    {
        set_exception_handler(function ($exception) {
            self::catchExceptionCallFunc($exception->getMessage());
        });
    }


    /**输出异常信息
     *
     * @param $content
     */
    private static function catchExceptionCallFunc($content)
    {
        $err_content = "Exception:" . $content;
        Debug::outputError($err_content);
    }

}