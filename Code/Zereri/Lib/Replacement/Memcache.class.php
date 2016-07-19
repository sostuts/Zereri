<?php
namespace Zereri\Lib\Replacement;

class Memcache extends Common
{
    protected static function getClassName()
    {
        return '\Zereri\Lib\Memcache';
    }
}