<?php
namespace Zereri\Lib\Replacement;

class Session extends Common
{
    protected static function getClassName()
    {
        return '\Zereri\Lib\Session';
    }
}