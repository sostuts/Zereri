<?php
//控制器调用
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