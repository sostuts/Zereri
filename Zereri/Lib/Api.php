<?php
namespace Zereri\Lib;

class Api
{
    /**控制器路径
     *
     * @var string
     */
    private $file_path;


    /**所有控制器名字
     *
     * @var array
     */
    private $controllers;


    /**控制器路径
     *
     * @var string
     */
    private $path;


    /**控制器注释
     *
     * @var array
     */
    private $controller_doc;


    /**控制器方法
     *
     * @var array
     */
    private $controller_method;


    /**控制器类名
     *
     * @var string
     */
    private $controller_class;


    /**每个api对应的获取方式
     *
     * @var string
     */
    private $api_method;


    /**每个控制器api文档
     *
     * @var array
     */
    private $api_doc;


    /**api的静态文件
     *
     * @var string
     */
    private $api_html_file;


    /**当前的函数名
     *
     * @var string
     */
    private $now_method;


    public function __construct()
    {
        $this->file_path = __ROOT__ . '/App/Controllers/';
        $this->controllers = $this->getControllersName();
        $this->path = $this->getApiPath();
    }


    /**获取所有控制器名字
     *
     * @return array
     */
    protected function getControllersName()
    {
        return scandir($this->file_path);
    }


    /**获取api url
     *
     * @return string
     */
    protected function getApiPath()
    {
        return dirname(dirname(($_SERVER["SERVER_PORT"] == $GLOBALS['user_config']['https_port'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']  . $_SERVER["REQUEST_URI"] . '/'));
    }


    /**获取所有控制器的api文档
     *
     * @return string
     */
    public function show()
    {
        if (!Debug::isDebug()) {
            $this->setApiFilePath()->createApiFile()->redirectToApiHtml();
        } else {
            $this->getEachControllerApiDoc()->apiDocToHtml();
        }
    }


    /**设置api html文件路径
     *
     * @return $this
     */
    private function setApiFilePath()
    {
        $this->api_html_file = __ROOT__ . '/public/api.html';

        return $this;
    }


    /**创建api html页面
     *
     * @return $this
     */
    private function createApiFile()
    {
        if (!is_file($this->api_html_file)) {
            $this->getEachControllerApiDoc()->apiDocToHtml($this->api_html_file);
        }

        return $this;
    }


    /**重定向至api html页面
     *
     */
    private function redirectToApiHtml()
    {
        Header::set([
            'Location' => $this->path . '/api.html'
        ]);
    }


    /**获取每个控制器的api文档
     *
     * @return $this
     */
    private function getEachControllerApiDoc()
    {
        foreach ($this->controllers as $file) {
            if ($this->isNotFile($file) || !$this->getApiHtml($file)) {
                continue;
            }
        }
        $this->parseDoc();

        return $this;
    }


    /**判断不是真实文件
     *
     * @param $file
     *
     * @return bool
     */
    private function isNotFile($file)
    {
        return $file === '.' || $file === '..';
    }


    /**获取api html
     *
     * @param $file
     *
     * @return bool
     */
    protected function getApiHtml($file)
    {
        return $this->matchControllerDoc($file) && $this->matchControllerClass($file);
    }


    /**匹配注释内容
     *
     * @param $file
     *
     * @return mixed
     */
    protected function matchControllerDoc($file)
    {
        $doc_method = $this->pregMatch('/\/\*\*(.*)\*\/.*function (.*)\(/smU', $this->getFileContent($file), 'all');

        if (!$doc_method) {
            return false;
        }

        return ($this->controller_doc[] = $doc_method[1]) && ($this->controller_method[] = $doc_method[2]);
    }


    /**获取控制器文件内容
     *
     * @param $file
     *
     * @return string
     */
    protected function getFileContent($file)
    {
        return file_get_contents($this->file_path . $file);
    }


    /**获取控制器类名
     *
     * @param $file
     *
     * @return bool
     */
    protected function matchControllerClass($file)
    {
        return $this->controller_class[] = $this->pregMatch('/^[^\.]*/', $file);
    }


    /**解析文件注释内容
     *
     * @return array|null
     * @throws UserException
     */
    protected function parseDoc()
    {
        foreach ($this->controller_doc as $class => $e_controller_doc) {
            foreach ($e_controller_doc as $key => $each_doc) {
                $this->now_method = $this->controller_class[ $class ] . '/' . $this->controller_method[ $class ][ $key ];

                $this->api_doc[ $class ][ $key ]['title'] = $this->pregMatch('/^[^\n]*/', $each_doc);
                $this->api_doc[ $class ][ $key ]['params'] = $this->handleParams($this->pregMatch('/@param ([^\n]*)/', $each_doc, 1, true));
                $this->api_doc[ $class ][ $key ]['return'] = $this->handleReturn($this->pregMatch('/@return ([^\n]*)/', $each_doc, 1));
                $this->api_doc[ $class ][ $key ]['api_method'] = $this->api_method;
                $this->api_doc[ $class ][ $key ]['url'] = $this->path . '/' . $this->now_method;
                $this->api_doc[ $class ][ $key ]['url_short'] = $this->now_method;
            }
        }

        return $this;
    }


    /**获取参数名字以及说明
     *
     * @param $params
     *
     * @return array|null
     * @throws UserException
     */
    protected function handleParams($params)
    {
        if (!$this->notNullParam($params)) {
            return [];
        }

        $arr_res = [];
        foreach ($params as $key => $each_param) {
            $arr_res[ $key ] = $this->getEachParamInfo($each_param);
        }

        return $arr_res;
    }


    /**是否为空参数并且设置api请求方法
     *
     * @param $params
     *
     * @return bool
     */
    private function notNullParam($params)
    {
        if ($params) {
            $this->api_method = 'POST | Json';

            return true;
        }

        $this->api_method = 'GET';
    }


    /**获取每个参数信息
     *
     * @param $param
     *
     * @return array
     * @throws UserException
     */
    private function getEachParamInfo($param)
    {
        $pieces = explode(' ', $this->removeMoreSpace($param));
        //参数必须有类型和名字的说明
        if (count($pieces) < 2) {
            throw new UserException("It must have type and name of the param in <pre>" . $this->now_method . " 's " . $param . "</pre>");
        }
        $param = [];
        $param['type'] = $pieces[0];
        $param['name'] = substr($pieces[1], 1);   //去除$符号
        list($param['need'], $param['desc']) = $this->getParamNeedAndDesc($pieces);

        return $param;
    }


    /**返回该参数的必须值以及说明
     *
     * @param $pieces
     *
     * @return array
     */
    private function getParamNeedAndDesc($pieces)
    {
        $count = count($pieces);
        if ($count === 4) {
            return [$pieces[2], $pieces[3]];
        } elseif ($count === 3) {
            if ($pieces[2] === '0' || $pieces[2] === '1') {
                return [$pieces[2], ''];
            }

            return [1, $pieces[2]];
        } else {
            return [1, ''];
        }
    }


    /**获取返回值说明
     *
     * @param $return
     *
     * @return null
     */
    protected function handleReturn($return)
    {
        if (!$return) {
            return NULL;
        }

        $pieces = explode(' ', $this->removeMoreSpace($return));
        $arr_res['format'] = in_array($pieces[0], ['json', 'xml', 'html']) ? array_shift($pieces) : 'json';
        foreach ($pieces as $key => $val) {
            list($arr_res['content'][ $key ]['name'], $arr_res['content'][ $key ]['desc']) = strpos($val, '.') ? explode('.', $val) : [$val, ''];
        }

        return $arr_res;
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


    /**加载或生成html页面
     *
     * @param string $fetch_file
     *
     * @return mixed
     */
    protected function apiDocToHtml($fetch_file = "")
    {
        Replacement\Smarty::load("api.html", ["arr" => $this->api_doc], $fetch_file);
    }


    /**匹配对应内容
     *
     * @param      $pattern
     * @param      $content
     * @param int  $classify
     * @param bool $array
     *
     * @return mixed
     */
    protected function pregMatch($pattern, $content, $classify = 0, $array = false)
    {
        if (preg_match_all($pattern, $content, $arr)) {
            if ('all' === $classify) {
                return $arr;
            }
            if (false === $array) {
                return $arr[ $classify ][0];
            }

            return $arr[ $classify ];
        }
    }

}