<?php
namespace App\Controllers;


use Zereri\Lib\Replacement\Queue;
use Zereri\Lib\Test;

class Example
{
    public $middle = [

        "all"  => "Test",
        "test" => ["fuck"]
    ];

    /**样本测试
     *
     * @return json name.Zereri
     */
    public function test()
    {

        $res = TB("users")->where("id", "=", 12)->select();
        $res2 = TB("users")->where("id", "=", 14)->select();

//        response(["name" => $res, "fuck" => $res2], "text");

    }


    public function shit()
    {
        $res = Test::curl("http://localhost/frame/public/Example/test", json_encode(["a" => "a"]));
        echo "<pre>";
        print_r($res);
        echo "</pre>";

    }

    public function e()
    {
        Queue::add(\App\Queues\Test::class, ["fuckyou"])->delay(5);

        response(["name" => "6"]);
    }

    public function fuck()
    {
        Session::set("a", "fuckyou");
        echo Session::get("a");
    }


    /**aa方法
     *
     * @param string $a
     * @param string $b
     * @param string $c
     *
     * @return content.shit
     *
     */
    public function aa($a, $b, $c)
    {
        response(["content" => $a . $b . $c]);
    }

}