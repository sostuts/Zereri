<?php
//控制器调用
function response($status_code, $data = NULL, $mode = 'json', $file = '', $shutdown = true, $header = "")
{
    Zereri\Lib\Header::set(config("status_code")[ $status_code ]);

    if ($header) {
        Zereri\Lib\Header::set($header);
    }

    Factory::newResponse($data, $mode, $file)->send();

    if ($shutdown) {
        die();
    }
}


function TB($table = '')
{
    return Factory::newSql($table);
}


function &config($config_name)
{
    $config_self =& \Zereri\Lib\Basic\Config::getConfigSelf($config_name);

    return $config_self;
}

function isConfigExist($config_name)
{
    $config_self =& \Zereri\Lib\Basic\Config::getConfigSelf($config_name);

    return isset($config_self);
}