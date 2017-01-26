<?php
namespace Zereri\Lib\Cache;

class Cache
{
    public function __call($func, $arguments)
    {
        $class = $this->getClass();

        return (new $class)->$func(...$arguments);
    }


    protected function getClass()
    {
        return ucfirst(config("cache.drive"));
    }
}