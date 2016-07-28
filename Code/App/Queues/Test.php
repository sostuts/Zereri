<?php
namespace App\Queues;

class Test implements InQueue
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function run()
    {
        $this->text;
    }
}