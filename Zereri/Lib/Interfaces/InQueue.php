<?php
namespace Zereri\Lib\Interfaces;

interface InQueue
{
    /**该类执行的程序
     *
     * @return mixed
     */
    public function run();
}