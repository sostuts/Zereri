<?php
//控制器调用
function response($status_code, $data = NULL, $mode = 'json', $file = '', $header = "")
{
    Zereri\Lib\Header::set(config("status_code")[ $status_code ]);

    if ($header) {
        Zereri\Lib\Header::set($header);
    }

    Factory::newResponse($data, $mode, $file)->send();
}


function TB($table = '')
{
    return Factory::newSql($table);
}


function config($name)
{
    return $GLOBALS["user_config"][ $name ];
}