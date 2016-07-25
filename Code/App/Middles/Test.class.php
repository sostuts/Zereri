<?php
namespace App\Middles;

class Test implements MiddleWare
{
    public function before($request)
    {
        echo "hello!";
    }

    public function after($request)
    {
        echo "goodBye!";
    }
}