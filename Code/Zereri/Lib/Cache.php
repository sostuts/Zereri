<?php
namespace Zereri\Lib;

class Cache
{
    public function __call($func, $arguments)
    {
        $class = $this->getClass();

        return (new $class)->$func(...$arguments);
    }

    protected function getClass()
    {
        return '\Zereri\Lib\\'.ucfirst(config("cache")["drive"]);
    }
}