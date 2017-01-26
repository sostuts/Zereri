<?php
namespace Zereri\Lib\Basic;


class HandleUrl
{
    public static function getVersionAndRouteFromUrl()
    {
        $version = "";
        $route = self::getRouteFromHttpUrl();

        if (self::isVersionControlTurnOn() && count($pieces = explode("/", $route, 2)) > 1) {
            $version = $pieces[0];
            $route = $pieces[1];
        }

        return [$version, "/" . $route];
    }


    private static function isVersionControlTurnOn()
    {
        return config("version_control");
    }


    private static function getRouteFromHttpUrl()
    {
        return $_SERVER['QUERY_STRING'] ?: substr($_SERVER["REQUEST_URI"], 1);
    }
}