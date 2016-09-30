<?php
namespace Zereri\Lib;

class Request
{
    /**http内容
     *
     * @var bool|mixed|string
     */
    private $data;


    public function __construct()
    {
        $this->data = $this->getData();
    }


    /**获取主体信息
     *
     * @return bool|mixed|string
     */
    private function getData()
    {
        if (!$this->isPost()) {
            return [];
        }

        if ($this->isForm()) {
            return $_POST;
        } else {
            return $this->getInputData();
        }
    }


    /**是否post请求
     *
     * @return bool
     */
    private function isPost()
    {
        return in_array($_SERVER['REQUEST_METHOD'], ["POST", "PUT", "PATCH"]);
    }


    /**判断是否为表单
     *
     * @return bool|int
     */
    private function isForm()
    {
        return strpos($_SERVER['CONTENT_TYPE'], 'form');
    }


    /**获取非表单内容
     *
     * @return bool|mixed|string
     */
    private function getInputData()
    {
        $data = $this->getPhpInput();

        if ($decode_data = $this->jsonDecode($data)) {
            return $decode_data;
        } else {
            return $data;
        }
    }


    /**获取只读流信息
     *
     * @return string
     */
    protected function getPhpInput()
    {
        return file_get_contents('php://input');
    }


    /**json反序列化
     *
     * @param $data
     *
     * @return bool|mixed
     */
    protected function jsonDecode($data)
    {
        $data = json_decode($data, true);
        if (is_array($data)) {
            return $data;
        } else {
            return false;
        }
    }


    public function data()
    {
        return $this->data;
    }
}