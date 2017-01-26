<?php
namespace Zereri\Lib\Basic;


class Index
{
    public static function haveNewConfigRouteFile($index_file_path)
    {
        $config_routes_file_path = __ROOT__ . "/App/Config/route.php";

        return !file_exists($index_file_path) || (filemtime($index_file_path) < filemtime($config_routes_file_path));
    }


    public static function saveIndexArrayToFile($file_path, $index_array)
    {
        file_put_contents($file_path, json_encode($index_array));
    }


    public static function getIndexArrayFromFile($file_path)
    {
        return json_decode(file_get_contents($file_path), true);
    }
}