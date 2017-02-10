<?php
namespace Zereri\Lib\Basic;


use Zereri\Lib\UserException;

class Controller_Info
{
    private $controller_info_filepath = __ROOT__ . "/Zereri/Lib/Indexes/Controllers/info_";


    private $version;


    public static function getControllerInfoByRequestConfigRoute($version, $request_config_route)
    {
        return (new Controller_Info($version, $request_config_route))->getControllerInfoArrayByRequestConfigRoute($request_config_route);
    }


    public function __construct($version, $config_route)
    {
        $this->version = $version;
        $this->controller_info_filepath .= $this->version . ".txt";
    }


    public function getControllerInfoArrayByRequestConfigRoute($request_config_route)
    {
        $request_controller_info_array =& $this->haveNewRoutesAndSaveNewIndexToFile_GetAllControllerInfoArray()[ $request_config_route ][ $_SERVER["REQUEST_METHOD"] ];
        if (!isset($request_controller_info_array)) {
            Common::response404NotFount();
        }

        return $request_controller_info_array;
    }


    private function haveNewRoutesAndSaveNewIndexToFile_GetAllControllerInfoArray()
    {
        if (Index::haveNewConfigRouteFile($this->controller_info_filepath)) {
            if (!$config_routes_array = Common::getConfigRoutes($this->version, "controller")) {
                Common::response404NotFount();
            }
            $controller_info_arr = $this->getControllerClass_Method_MiddleWaresByForeachConfigRoutes($config_routes_array);
            Index::saveIndexArrayToFile($this->controller_info_filepath, $controller_info_arr);
        } else {
            $controller_info_arr = Index::getIndexArrayFromFile($this->controller_info_filepath);
        }

        return $controller_info_arr;
    }


    private function getControllerClass_Method_MiddleWaresByForeachConfigRoutes($config_routes_array)
    {
        $controller_info_arr = [];

        foreach ($config_routes_array as $each_config_route => $each_route_value_array) {
            foreach ($each_route_value_array as $method => $each_route_value) {
                $controller_class = NULL;
                $controller_method = NULL;
                $controller_middlewares = $this->getRouteGlobalMiddleWares();
                $callback = NULL;

                if (is_callable($each_route_value)) {
                    $callback = $each_route_value;
                } elseif ($this->withoutMiddleWare($each_route_value)) {
                    list($controller_class, $controller_method) = $this->getControllerClass_Method($each_route_value);
                } else {
                    list($controller_class, $controller_method) = $this->getControllerClass_Method($each_route_value[0]);

                    $controller_middlewares = $this->getControllerMiddleWares($each_route_value, $controller_middlewares);
                }

                $controller_info_arr[ $each_config_route ][ $method ] = [$controller_class, $controller_method, $controller_middlewares, $callback];
            }
        }

        return $controller_info_arr;
    }


    private function getControllerClass_Method($route_value)
    {
        return explode("@", str_replace('/\\//', '\\', $route_value));
    }


    private function withoutMiddleWare($route_value)
    {
        return !is_array($route_value);
    }


    private function getRouteGlobalMiddleWares()
    {
        $global_middlewares_group_name = "ALL";

        return $this->getControllerMiddleWaresArrayFromMiddleWareGroups($global_middlewares_group_name, true);
    }


    private function getControllerMiddleWares(&$route_value, $global_middlewares)
    {
        $middlewares =& $route_value[1];
        $middleware_group_name =& $route_value[2];

        $route_value_middlewares = $this->getControllerMiddleWaresArraryFromRouteValue($middlewares);

        $group_middlewares = $this->getControllerMiddleWaresArrayFromMiddleWareGroups($middleware_group_name);

        return array_merge($global_middlewares, $group_middlewares, $route_value_middlewares);
    }


    private function getControllerMiddleWaresArraryFromRouteValue($middlewares)
    {
        if (!isset($middlewares)) {
            return [];
        }

        return is_array($middlewares) ? $middlewares : [$middlewares];
    }


    private function getControllerMiddleWaresArrayFromMiddleWareGroups(&$group_name, $global_group = FALSE)
    {
        if (!isset($group_name)) {
            return [];
        }

        $middleware_group_value =& config("route.MiddleWareGroups.$group_name");

        if (!isset($middleware_group_value) && !$global_group) {
            throw new UserException("The MiddleWare Group <b>$group_name</b> Does Not Exist!");
        }

        if (!is_array($middleware_group_value)) {
            return [$middleware_group_value];
        }

        return $middleware_group_value;
    }
}