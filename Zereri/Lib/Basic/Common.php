<?php
namespace Zereri\Lib\Basic;


class Common
{
    public static function getConfigRoutes($version, $mode)
    {
        if ($version) {
            if (!isConfigExist("route.$version")) {
                self::response404NotFount();
            }

            $config_routes_arr = config("route.$version");
        } else {
            $config_routes_arr = config("route");

            if (isset($config_routes_arr["MiddleWareGroups"])) {
                unset($config_routes_arr["MiddleWareGroups"]);
            }
        }

        switch ($mode) {
            case "route":
                $config_routes_arr = array_keys($config_routes_arr);
                break;
            case "controller":
                break;
        }

        return $config_routes_arr;
    }


    public static function response404NotFount()
    {
        response(404, "404", "text", "", 1);
    }
}