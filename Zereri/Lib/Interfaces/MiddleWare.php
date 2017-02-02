<?php
namespace Zereri\Lib\Interfaces;

interface MiddleWare
{
    /**前置中间件
     *
     * @param $request
     *
     * @return mixed
     */
    public function before($request);


    /**后置中间件
     *
     * @param $request
     *
     * @return mixed
     */
    public function after($request);
}