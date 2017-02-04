<?php

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
$request = Factory::newRequest();

$controller = Factory::newController();

$controller->setPostData($request->getData())->call();
