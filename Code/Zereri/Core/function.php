<?php
//给控制器调用
function response($data=NULL,  $mode = 'json', $file = '',array $header = ['X-Powered-By' => 'Zereri'])
{
    Zereri\Lib\Header::set($header);

    (new Zereri\Lib\Response($data, $mode, $file))->send();
}


function TB($table='')
{
    return new \Zereri\Lib\Sql($table);
}
