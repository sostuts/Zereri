<?php
namespace Zereri\Lib;

class Test
{
    public static function curl($url, $post = "", $header = ["Content-Type" => "text/json"], $cookie = "")
    {
        error_reporting(E_ALL || ~E_NOTICE);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $newcookie = "";
        //COOKIE
        if ($cookie) {
            $newcookie = tempnam("./", "cookie");
            if ($cookie == "new") {
                curl_setopt($curl, CURLOPT_COOKIEJAR, $newcookie);
            } else {
                curl_setopt($curl, CURLOPT_COOKIEFILE, $cookie);
                curl_setopt($curl, CURLOPT_COOKIEJAR, $newcookie);
            }
        }
        //POST 方式
        if ($post) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }

        //header 头部
        if ($header) {
            $header_arr = [];
            foreach ($header as $column => $value) {
                $header_arr[] = $column . ":" . $value;
            }
            curl_setopt($curl, CURLOPT_HTTPHEADER, $header_arr);
        }
        //信任所有证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        //执行
        $res = curl_exec($curl);
        curl_close($curl);

        return array("result" => $res, "cookie" => $newcookie);
    }
}