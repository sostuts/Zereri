<?php
namespace Zereri\Lib\Basic;

use Zereri\Lib\Db\Sql;
use Zereri\Lib\Register;

class Factory
{
    /**实例化Request类
     *
     * @return Request
     */
    public static function newRequest()
    {
        $request = new Request();
        Register::set("data", $request->getData());

        return $request;
    }


    /**实例化Call_Info类
     *
     * @return Call_Info
     */
    public static function newCallInfo()
    {
        $call_info = new Call_Info();
        Register::set("class", $call_info->getClass());
        Register::set("method", $call_info->getMethod());

        return $call_info;
    }


    /**实例控制器调用类
     *
     * @return CallController
     */
    public static function newController()
    {
        $call_info = self::newCallInfo();

        return new Call($call_info->getClass(), $call_info->getMethod(), $call_info->getUrlParams(), $call_info->getMiddleWares(), $call_info->getCallBack());
    }


    /**实例化回复类
     *
     * @param $data
     * @param $mode
     * @param $file
     *
     * @return Response
     */
    public static function newResponse($data, $mode, $file)
    {
        return new Response($data, $mode, $file);
    }


    /**实例化Sql类
     *
     * @param $table
     *
     * @return Sql
     */
    public static function newSql($table)
    {
        return new Sql($table);
    }
}