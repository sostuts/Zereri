<?php
namespace Zereri\Lib;

interface InQueue
{
    /**该类执行的程序
     *
     * @return mixed
     */
    public function run();
}