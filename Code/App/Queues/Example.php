<?php
namespace App\Queues;

class Example implements InQueue
{
    private $text;

    public function __construct($text)
    {
        $this->text = $text;
    }

    public function run()
    {
        \App\Controllers\Cache::set("text", $this->text);
    }
}