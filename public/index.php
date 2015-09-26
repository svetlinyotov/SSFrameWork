<?php

ini_set('display_errors', 1);
error_reporting(E_ALL ^ E_NOTICE);

include_once '../ssframe/App.php';

$app = \SSFrame\App::getInstance();

function env($param) {
    return \SSFrame\Loader::env($param);
}
function config($param) {
    return \SSFrame\Config::getInstance()->get($param);
}

$app->run();