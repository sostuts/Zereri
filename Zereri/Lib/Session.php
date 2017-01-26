<?php
namespace Zereri\Lib;

class Session
{
    public static function set($key, $value)
    {
        self::isStartOrNotStartSession();
        $session =& self::getSessionSelf($key);
        $session = $value;
    }


    public static function get($key)
    {
        self::isStartOrNotStartSession();
        $value = $session =& self::getSessionSelf($key);

        return $value;
    }


    public static function remove($key)
    {
        self::set($key, NULL);
    }


    protected static function &getSessionSelf($key)
    {
        $keys = explode('.', $key);
        switch (count($keys)) {
            //no break at all
            case 1:
                return $_SESSION[ $keys[0] ];
            case 2:
                return $_SESSION[ $keys[0] ][ $keys[1] ];
            case 3:
                return $_SESSION[ $keys[0] ][ $keys[1] ][ $keys[2] ];
            case 4:
                return $_SESSION[ $keys[0] ][ $keys[1] ][ $keys[2] ][ $keys[3] ];
            case 5:
                return $_SESSION[ $keys[0] ][ $keys[1] ][ $keys[2] ][ $keys[3] ][ $keys[4] ];
            default:
                throw new UserException('Out Of The Session Index!');
        }
    }


    protected static function isStartOrNotStartSession()
    {
        if (!isset($_SESSION)) {
            self::setSessionSavePath();
            self::setHttpOnlyCookie();

            session_start();
        }
    }


    protected static function setSessionSavePath()
    {
        switch (config("session.drive")) {
            case "file":
                session_save_path($GLOBALS['config']['session']['path']);
                break;
            case "memcached":
                self::setSessionSaveIni("memcached", self::implodeServerArrayToString(config("memcached.server.0")));
                break;
            case "redis":
                $path = config("redis.cluster") ? config("redis.server.0") : self::implodeServerArrayToString(config("redis.server"));
                self::setSessionSaveIni("redis", $path);
                break;
        }
    }


    protected static function implodeServerArrayToString($server_array)
    {
        return implode(":", $server_array);
    }


    protected static function setSessionSaveIni($drive, $path)
    {
        ini_set("session.save_handler", $drive);
        ini_set("session.save_path", $path);
    }


    protected static function setHttpOnlyCookie()
    {
        session_set_cookie_params(0, "/", "", FALSE, TRUE);
    }
}