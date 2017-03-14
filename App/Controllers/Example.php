<?php
namespace App\Controllers;

class Example
{
    /**样本测试
     *
     * @return name:Zereri
     */
    public function test()
    {
        response(200, ["name" => "zereri"]);
    }
}