<?php
namespace App\Controllers;

use Zereri\Lib\Test;

class Example
{
    /**样本测试
     *
     * @return json name.Zereri
     */
    public function test($a)
    {
        if ($a == "a") {
            $res = TB("users")->where("id", "=", 12)->select();
            $res2 = TB("users")->where("id", "=", 14)->select();

            response(["name" => $res, "fuck" => $res2], "text");
        }
    }


    public function shit()
    {
        $res = Test::curl("http://localhost/frame/public/Example/test", json_encode(["a" => "a"]));
        echo "<pre>";
        print_r($res);
        echo "</pre>";

    }
}