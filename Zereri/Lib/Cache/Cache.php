<?php
namespace Zereri\Lib\Cache;

use Zereri\Lib\Register;

class Cache
{
    public function __call($func, $arguments)
    {
        if ($this->isFirstCallCache()) {
            $class = $this->getCacheClassName();
            $cache_instance = new $class;
            $this->registerCacheInstance($cache_instance);
        } else {
            $cache_instance = $this->getCacheInstance();
        }

        return $cache_instance->$func(...$arguments);
    }


    protected function isFirstCallCache()
    {
        return !Register::has("CacheInstance");
    }


    protected function registerCacheInstance($cache_instance)
    {
        Register::set("CacheInstance", $cache_instance);
    }


    protected function getCacheInstance()
    {
        return Register::get("CacheInstance");
    }


    protected function getCacheClassName()
    {
        return "\Zereri\Lib\Cache\\" . ucfirst(config("cache.drive"));
    }
}