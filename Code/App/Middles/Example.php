<?php
namespace App\Middles;

class Example implements MiddleWare
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