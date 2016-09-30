<?php
namespace Zereri\Lib;


class Document
{
    /**路由规则
     *
     * @var array
     */
    private $routes;


    /**方法名
     *
     * @var array
     */
    private $functions;


    /**控制器的命名空间
     *
     * @var string
     */
    private $controller_namespace;


    /**api文档
     *
     * @var array
     */
    private $api_array = [];


    public function __construct()
    {
        $this->controller_namespace = '\App\Controllers\\';
        $this->routes =& $GLOBALS["route"];
    }

    public function init()
    {
        $this->setApiArray()->output();
    }

    protected function output()
    {
        echo "<pre>";
        print_r($this->api_array);
        echo "</pre>";
    }


    /**api说明->数组
     *
     * @return $this
     */
    protected function setApiArray()
    {
        if ($GLOBALS["user_config"]["version_control"]) {
            foreach ($this->routes as $version => $route) {
                $this->api_array[ $version ] = $this->getApiGroupAndValues($route);
            }
        } else {
            $this->api_array = $this->getApiGroupAndValues($this->routes);
        }

        return $this;
    }


    /**获取某版本下的api组与值
     *
     * @param $route
     *
     * @return array
     * @throws UserException
     */
    protected function getApiGroupAndValues($route)
    {
        $api_groups = [];
        $this->functions = $this->getCallFunctionList($route);

        foreach ($this->functions as &$function) {
            if (!$document = $this->getFunctionDoc($function)) {
                continue;
            }

            $group = $this->getInfoFromDoc($document, $function);
            $this->setParamDefault($function);

            //无分组
            if (!$group) {
                $group = "Others";
            }

            $api_groups[ $group ][] =& $function;
        }

        return $api_groups;
    }


    /**设置文档的参数默认值
     *
     * @param $function
     *
     * @throws UserException
     */
    protected function setParamDefault(&$function)
    {
        foreach ($this->getFunctionParamDefault($function) as $name => $default) {
            if (!isset($function["params"][ $name ])) {
                throw new UserException("It needs the param document of <b>$$name</b> in " . $function["class"] . "@" . $function["function"]);
            }

            $function["params"][ $name ]["default"] = $default;
        }
    }


    /**获取被路由指向的控制器函数列表(不包括版本值)
     *
     * @param $route
     *
     * @return array
     */
    protected function getCallFunctionList($route)
    {
        $function_arr = [];
        foreach ($route as $url => $call) {
            foreach ($call as $method => $function) {
                //修改路径为命名空间路径再分割
                $class_function = explode("@", preg_replace('/\\//', '\\', $function));
                $function_arr[] = [
                    "url"      => $url,
                    "method"   => $method,
                    "class"    => $this->controller_namespace . $class_function[0],
                    "function" => $class_function[1]
                ];
            }
        }

        return $function_arr;
    }


    /**获取函数的参数默认值
     *
     * @param array $function
     *
     * @return array
     * @throws UserException
     */
    protected function getFunctionParamDefault(array $function)
    {
        if (!method_exists($function["class"], $function["function"])) {
            throw new UserException("Route's " . $function["url"] . " can't call the Controller " . $function["class"] . "@" . $function["function"]);
        }

        $params = [];
        $function = new \ReflectionMethod($function["class"], $function["function"]);
        foreach ($function->getParameters() as $param) {
            $params[ $param->getName() ] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : "";
        }

        return $params;
    }


    /**匹配函数的文档
     *
     * @param array $function
     *
     * @return mixed
     */
    protected function getFunctionDoc(array $function)
    {
        $function["class"] = $this->changePathSign($function["class"]) . ".php";
        $content = file_get_contents(__ROOT__ . $function["class"]);

        $document = $this->pregMatch('/\/\*\*(.(?!\*\/))*.{1,50}function ' . $function["function"] . '\(/Usm', $content, 0);

        return $document;
    }


    /**修改路径的 / \ 符号
     *
     * @param $path
     *
     * @return mixed
     */
    private function changePathSign($path)
    {
        return preg_replace('/\\\/', DIRECTORY_SEPARATOR, $path);
    }


    /**从文档获取信息
     *
     * @param $document
     * @param $function
     *
     * @return array|string
     * @throws UserException
     */
    protected function getInfoFromDoc($document, &$function)
    {
        $function["title"] = $this->pregMatch('/^\/\*\*([^\n]*)/', $document, 1);
        $function["params"] = $this->parseParams($this->pregMatch('/@param ([^\n]*)/i', $document, 1, true));
        $function["header"] = $this->parseParams($this->pregMatch('/@header ([^\n]*)/i', $document, 1, true), true);
        $function["return"] = $this->parseReturn($this->pregMatch('/@return ([^\n]*)/i', $document, 1));
        $function["example"] = $this->parseExample($this->pregMatch('/@example ([^\n]*)/i', $document, 1, true));

        return $this->pregMatch('/@group ([^\n]*)/', $document, 1);
    }


    /**解析header以及参数列表
     *
     * @param array $params
     * @param bool  $header 是否为header
     *
     * @return array
     */
    protected function parseParams(array $params, $header = false)
    {
        $param_list = [];
        foreach ($params as $param) {
            $type_name_desc = $this->explodeSpace($param, 3);
            //去除$符号
            $name = $header ? $type_name_desc[1] : substr($type_name_desc[1], 1);
            $param_list[ $name ]["type"] = $type_name_desc[0];
            $param_list[ $name ]["description"] = $type_name_desc[2];
        }

        return $param_list;
    }


    /**解析返回值
     *
     * @param $return
     *
     * @return array
     */
    protected function parseReturn($return)
    {
        $return_list = [];
        if ($return) {
            $return = $this->explodeSpace($return);
            foreach ($return as $e_return) {
                list($name, $description) = explode(":", $e_return, 2);
                $return_list[ $name ] = $description;
            }

            ksort($return_list);
        }

        return $return_list;
    }


    /**解析例子
     *
     * @param $examples
     *
     * @return array
     */
    protected function parseExample($examples)
    {
        $example_list = [];
        foreach ($examples as $example) {
            list($status_code, $content) = $this->explodeSpace($example);
            $example_list[ $status_code ] = $content;
        }

        return $example_list;
    }


    /**以空格为单位分割
     *
     * @param $content
     * @param $max_part
     *
     * @return array
     */
    protected function explodeSpace($content, $max_part = 0)
    {
        $content = $this->removeMoreSpace($content);
        if (0 !== $max_part) {
            return explode(' ', $content, $max_part);
        }

        return explode(' ', $content);
    }


    /**移除两个或以上的空格
     *
     * @param $content
     *
     * @return mixed
     */
    protected function removeMoreSpace($content)
    {
        return preg_replace('/[\s ]{2,}/', ' ', trim($content));
    }


    /**匹配
     *
     * @param      $pattern
     * @param      $content
     * @param int  $part  返回指定部分
     * @param bool $greed 贪婪，返回数组
     *
     * @return array|string
     */
    protected function pregMatch($pattern, $content, $part = 0, $greed = FALSE)
    {
        if (!preg_match_all($pattern, $content, $result)) {
            return [];
        }

        if ('all' === $part) {
            return $result;
        }

        if (TRUE === $greed) {
            return $result[ $part ];
        }

        return trim($result[ $part ][0]);
    }
}