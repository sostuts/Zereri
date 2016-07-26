<?php
namespace Zereri\Lib;

class Session
{
    /**设置session值
     *
     * @param $key
     * @param $value
     *
     * @throws UserException
     */
    public static function set($key, $value)
    {
        self::isStart();
        $session =& self::getSession($key);
        $session = $value;
    }


    /**获取session值
     *
     * @param $key
     *
     * @return mixed
     * @throws UserException
     */
    public static function get($key)
    {
        self::isStart();
        $value = $session =& self::getSession($key);

        return $value;
    }


    /**清空指定session值
     *
     * @param $key
     */
    public static function remove($key)
    {
        self::set($key, NULL);
    }


    /**获取session对象
     *
     * @param $key
     *
     * @return mixed
     * @throws UserException
     */
    protected static function &getSession($key)
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
                throw new UserException('Out of the index!');
        }
    }


    /**
     *  判断是否开启 & 启动session
     */
    protected static function isStart()
    {
        if (!isset($_SESSION)) {
            if ("memcached" === $GLOBALS['user_config']['session']['drive']) {
                ini_set("session.save_handler", "memcache");
                ini_set("session.save_path", "tcp://" . implode(":", $GLOBALS['user_config']['memcached']['server'][0]));
            }
            session_save_path($GLOBALS['config']['session']['path']);
            session_start();
        }
    }
}