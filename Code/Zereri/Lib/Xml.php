<?php
namespace Zereri\Lib;

class Xml
{
    //版本
    private $version = '1.0';

    //编码
    private $encoding = 'UTF-8';

    private $content;
    private $xml;


    public function __construct($content)
    {
        $this->content = $content;
        $this->setHeader();
    }


    /**
     * 设置Header
     */
    private function setHeader()
    {
        Header::set(['Content-type' => 'text/xml']);
    }

    /**数组转换xml
     *
     * @return mixed
     */
    public function create()
    {
        $this->xmlCreate();
        $this->xmlAdd('root', $this->content);
        $this->xmlEnd();

        return $this->content;
    }


    /**
     * 创建XmlWriter实例
     */
    private function xmlCreate()
    {
        $this->xml = new \XmlWriter();
        $this->xml->openMemory();
        $this->xml->startDocument($this->version, $this->encoding);
    }


    /**添加xml节点
     *
     * @param $element
     * @param $content
     */
    private function xmlAdd($element, $content)
    {
        $this->xml->startElement($element);
        foreach ($content as $key => $val) {
            if (is_array($val)) {
                $this->xmlAdd($key, $val);
                continue;
            }
            $this->xml->writeElement($key, $val);
        }
        $this->xml->endElement();
    }


    /**
     * 返回xml内容
     */
    private function xmlEnd()
    {
        $this->content = $this->xml->outputMemory(true);
    }
}