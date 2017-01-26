<?php
namespace Zereri\Lib\Basic;


class Route
{
    /**路由规则索引文件路径
     *
     * @var string
     */
    private $treated_routes_filepath = __ROOT__ . "/Zereri/Lib/Indexes/Routes/route_";


    /**路由规则索引内容
     *
     * @var array|mixed
     */
    private $treated_routes;


    /**用户请求的路由版本
     *
     * @var string
     */
    private $version;


    /**用户请求的路由内容
     *
     * @var string
     */
    private $user_request_route;


    public static function getConfigRoute_UrlParamsFromTreatedRoute($version, $user_request_route)
    {
        return (new Route($version, $user_request_route))->getConfigRoute_UrlParamsFromTreatedRouteOrNotThrow404NotFound();
    }


    public function __construct($version, $user_request_route)
    {
        $this->version = $version;
        $this->user_request_route = $user_request_route;
        $this->treated_routes_filepath .= $this->version . ".txt";
        $this->treated_routes = $this->haveNewRoutesAndSaveNewIndexToFile_GetTreatedRoutes();
    }


    private function haveNewRoutesAndSaveNewIndexToFile_GetTreatedRoutes()
    {
        if (Index::haveNewConfigRouteFile($this->treated_routes_filepath)) {
            if (!$config_routes_array = Common::getConfigRoutes($this->version, "route")) {
                Common::response404NotFount();
            }
            $treated_routes = $this->getNoParam_WithParamRoutesArrayByForeachConfigRoutes($config_routes_array);
            Index::saveIndexArrayToFile($this->treated_routes_filepath, $treated_routes);
        } else {
            $treated_routes = Index::getIndexArrayFromFile($this->treated_routes_filepath);
        }

        return $treated_routes;
    }


    private function getNoParam_WithParamRoutesArrayByForeachConfigRoutes($config_routes)
    {
        $routes = [];
        foreach ($config_routes as $config_each_route) {
            if (preg_match('/\\{.*\\}/Usm', $config_each_route)) {
                $treated_route = preg_replace('/\\{.*\\}/Usm', '([^\\/]*)', $config_each_route);
                $first_word_ascii = $this->getFirstWordAsciiFromRoute($config_each_route);

                if (isset($routes["withParams"][ $first_word_ascii ])) {
                    array_push($routes["withParams"][ $first_word_ascii ], $treated_route);
                } else {
                    $routes["withParams"][ $first_word_ascii ] = [$treated_route];
                }

                $routes["withParamsRules"][ $treated_route ] = $config_each_route;
            } else {
                $routes["withoutParams"][] = $config_each_route;
            }
        }

        return $routes;
    }


    private function getFirstWordAsciiFromRoute($route)
    {
        $first_word = $this->getFirstWordFromRoute($route);

        return $this->stringToAscii($first_word);
    }


    private function getFirstWordFromRoute($route)
    {
        return explode("/", $route, 3)[1];
    }


    private function stringToAscii($string)
    {
        $ascii = "";
        $str_length = strlen($string);

        for ($i = 0; $i < $str_length; $i++) {
            $ascii .= ord($string[ $i ]);
        }

        return $ascii;
    }


    public function getConfigRoute_UrlParamsFromTreatedRouteOrNotThrow404NotFound()
    {
        $config_route = NULL;
        $url_params = NULL;

        if ($this->isWithoutParamsRoute($this->user_request_route)) {
            $config_route = $this->user_request_route;
        } elseif ($configRoute_urlParams = $this->isWithParamsRouteAndGetConfigRoute_UrlParams($this->user_request_route)) {
            $config_route = $configRoute_urlParams[0];
            $url_params = $configRoute_urlParams[1];
        } else {
            Common::response404NotFount();
        }

        return [$config_route, $url_params];
    }


    private function isWithoutParamsRoute($route)
    {
        return in_array($route, $this->treated_routes["withoutParams"]);
    }


    private function isWithParamsRouteAndGetConfigRoute_UrlParams($route)
    {
        $first_word_ascii = $this->getFirstWordAsciiFromRoute($route);
        $treated_routes =& $this->treated_routes["withParams"][ $first_word_ascii ];
        if (isset($treated_routes)) {
            foreach ($treated_routes as $treated_each_route) {
                if (preg_match('#^' . $treated_each_route . '$#', $route, $params_value_arr)) {
                    $url_params = array_slice($params_value_arr, 1);
                    $config_route = $this->treated_routes["withParamsRules"][ $treated_each_route ];

                    return [$config_route, $url_params];
                }
            }
        }

        return false;
    }
}