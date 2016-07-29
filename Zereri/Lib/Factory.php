<?php
namespace Zereri\Lib;


class Factory
{
    /**实例化Request类
     *
     * @return Request
     */
    public static function newRequest()
    {
        $request = new Request();
        Register::set("data", $request->data());

        return $request;
    }


    /**实例化HandleUri类
     *
     * @return HandleUri
     */
    public static function newHandleUri()
    {
        $url = new HandleUri();
        Register::set("method", $url->getMethod());

        return $url;
    }


    /**实例控制器调用类
     *
     * @return CallController
     */
    public static function newController()
    {
        $url = self::newHandleUri();

        return new Call($url->getClass(), $url->getMethod());
    }


    /**实例化回复类
     *
     * @param array ...$params
     *
     * @return Response
     */
    public static function newResponse(...$params)
    {
        return new Response(...$params);
    }


    /**实例化Sql类
     *
     * @param array ...$params
     *
     * @return Sql
     */
    public static function newSql(...$params)
    {
        return new Sql(...$params);
    }
}