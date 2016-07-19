<?php

//xhprof_enable();


/**
 * Zereri , A PHP Framework
 *
 * @verson beta
 * @author Zeffee <me@zeffee.com>
 */


//require some required files
require __DIR__ . '/../Zereri/load.php';


/**
 * Run
 *
 * =>get  the request
 * =>call the controller
 * =>send the response
 */
$request = new Request();

$controller = new HandleUri();

(new CallController($controller->getClass(), $controller->getMethod()))
    ->setPost($request->data())
    ->call();


// 要测试的php代码


//$data = xhprof_disable();   //返回运行数据
//
//// xhprof_lib在下载的包里存在这个目录,记得将目录包含到运行的php代码中
//include_once __DIR__ . "/../../xhprof-php7/xhprof_lib/utils/xhprof_lib.php";
//include_once __DIR__ . "/../../xhprof-php7/xhprof_lib/utils/xhprof_runs.php";
//
//$objXhprofRun = new XHProfRuns_Default();
//
//// 第一个参数j是xhprof_disable()函数返回的运行信息
//// 第二个参数是自定义的命名空间字符串(任意字符串),
//// 返回运行ID,用这个ID查看相关的运行结果
//$run_id = $objXhprofRun->save_run($data, "xhprof");
//var_dump($run_id);