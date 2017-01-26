<?php
namespace Zereri\Lib;

class CatchErrors
{
    /**
     * notice warning strict ...errors
     */
    public static function customError()
    {
        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            self::customErrorCallFunc($errno, $errstr, $errfile, $errline);
        });
    }


    private static function customErrorCallFunc($errno, $errstr, $errfile, $errline)
    {
        $err_type = self::getErrorTypeByErrorCode($errno);
        self::sendCustomErrorContentToHtml($err_type, $errstr, $errfile, $errline);
        self::markCustomErrorContentToLog($err_type, $errstr, $errfile, $errline);
    }


    private static function sendCustomErrorContentToHtml($err_type, $errstr, $errfile, $errline)
    {
        $err_content = $err_type . ": $errstr<br /> Error on line $errline in $errfile<br />";
        Debug::outputError($err_content);
    }


    private static function markCustomErrorContentToLog($err_type, $errstr, $errfile, $errline)
    {
        Log::mark($err_type . "   " . $errstr . "  Error on line $errline in $errfile");
    }


    public static function getErrorTypeByErrorCode($code)
    {
        switch (intval($code)) {
            case 1:
                $var = '(E_ERROR)';
                break;
            case 2:
                $var = '(E_WARNING)';
                break;
            case 4:
                $var = '(E_PARSE)';
                break;
            case 8:
                $var = '(E_NOTICE)';
                break;
            case 16:
                $var = '(E_CORE_ERROR)';
                break;
            case 32:
                $var = '(E_CORE_WARNING)';
                break;
            case 64:
                $var = '(E_COMPILE_ERROR)';
                break;
            case 128:
                $var = '(E_COMPILE_WARNING)';
                break;
            case 256:
                $var = '(E_USER_ERROR)';
                break;
            case 512:
                $var = '(E_USER_WARNING)';
                break;
            case 1024:
                $var = '(E_USER_NOTICE)';
                break;
            case 2048:
                $var = '(E_STRICT)';
                break;
            case 4096:
                $var = '(E_RECOVERABLE_ERROR)';
                break;
            case 8191:
                $var = '(E_ALL)';
                break;
        }

        return $var;
    }


    /**
     * Fatal Error
     */
    public static function shutdownError()
    {
        register_shutdown_function(function () {
            self::shutdownErrorCallFunc();
        });
    }


    private static function shutdownErrorCallFunc()
    {
        if ($err_content = error_get_last()) {
            $err_content = $err_content['message'] . "<br>" . $err_content['file'] . ' line:' . $err_content['line'];
            Debug::outputError($err_content);
        }
    }
}