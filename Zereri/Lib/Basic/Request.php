<?php
namespace Zereri\Lib\Basic;

class Request
{
    /**http请求附带的数据
     *
     * @var bool|mixed|string
     */
    private $data;


    public function __construct()
    {
        $this->data = $this->getRequestData();
    }


    private function getRequestData()
    {
        if (!Request::isPost_Put_Patch()) {
            return [];
        }

        return $_POST ?: $this->getDecodePHPInputData();
    }


    public static function isPost_Put_Patch()
    {
        return in_array($_SERVER['REQUEST_METHOD'], ["POST", "PUT", "PATCH"]);
    }


    private function getDecodePHPInputData()
    {
        $data = $this->getPHPInput();

        if ($decode_data = $this->jsonDecode($data)) {
            return $decode_data;
        } else {
            return $data;
        }
    }


    protected function getPHPInput()
    {
        return file_get_contents('php://input');
    }


    protected function jsonDecode($data)
    {
        $data = json_decode($data, true);
        if (is_array($data)) {
            return $data;
        } else {
            return false;
        }
    }

    public function getData()
    {
        return $this->data;
    }
}