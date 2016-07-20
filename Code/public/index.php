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
$request = new Request();

$controller = new HandleUri();

(new CallController($controller->getClass(), $controller->getMethod()))
    ->setPost($request->data())
    ->call();
