<?php
namespace Zereri\Lib;

use Zereri\Lib\Replacement\Smarty;

class Response
{
    /**输出的内容
     *
     * @var string || mixed
     */
    private $content;


    /**序列化模式
     *
     * @var string
     */
    private $mode;


    /**html文件
     *
     * @var string
     */
    private $file;


    public function __construct($content, $mode, $file)
    {
        $this->content = $content;
        $this->mode = $mode;
        $this->file = $file;
    }


    /**
     * 输出序列化之后的内容
     */
    public function send()
    {
        $this->{$this->mode}()->output();
    }


    /**json格式
     *
     * @return $this
     */
    private function json()
    {
        $this->content = json_encode($this->content);

        return $this;
    }


    /**xml格式
     *
     * @return $this
     */
    private function xml()
    {
        $this->content = (new Xml($this->content))->create();

        return $this;
    }


    /**纯文本
     *
     * @return $this
     */
    private function text()
    {
        return $this;
    }


    /**
     * html解析
     */
    private function html()
    {
        Smarty::load($this->file, $this->content);

        die();
    }

    /**
     * print
     */
    private function output()
    {
        print_r($this->content);
    }
}