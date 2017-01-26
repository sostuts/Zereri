<?php
namespace Zereri\Lib\Basic;

class Xml
{
    private $version = '1.0';
    private $encoding = 'UTF-8';
    private $content;
    private $xml;


    public function __construct($content)
    {
        $this->content = $content;
        $this->setXmlHeader();
    }


    private function setXmlHeader()
    {
        Header::set(['Content-type' => 'text/xml']);
    }


    public function create()
    {
        $this->xmlCreate();
        $this->xmlAdd('root', $this->content);
        $this->xmlEnd();

        return $this->content;
    }


    private function xmlCreate()
    {
        $this->xml = new \XmlWriter();
        $this->xml->openMemory();
        $this->xml->startDocument($this->version, $this->encoding);
    }


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


    private function xmlEnd()
    {
        $this->content = $this->xml->outputMemory(true);
    }
}