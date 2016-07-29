<?php
namespace Zereri\Lib;

interface MiddleWare
{
    /**前置中间件
     *
     * @return mixed
     */
    public function before($request);


    /**后置中间件
     *
     * @return mixed
     */
    public function after($request);
}