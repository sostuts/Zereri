<?php
namespace Zereri\Lib\Basic;

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


    public function send()
    {
        switch ($this->mode) {
            case "json":
                $this->isArrayContentAndJsonEncode()->output();
                break;
            case "xml":
                $this->xmlFormatContent()->output();
                break;
            case "text":
                $this->textFormatContent()->output();
                break;
            case "html":
                $this->loadHtmlAndSmartyRender();
                break;
        }
    }


    private function isArrayContentAndJsonEncode()
    {
        $this->content = is_array($this->content) ? json_encode($this->content) : $this->content;

        return $this;
    }


    private function xmlFormatContent()
    {
        $this->content = (new Xml($this->content))->create();

        return $this;
    }


    private function textFormatContent()
    {
        return $this;
    }


    private function loadHtmlAndSmartyRender()
    {
        Smarty::load($this->file, $this->content);

        die();
    }

    private function output()
    {
        print_r($this->content);
    }
}