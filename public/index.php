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
function asset($path){
    $uri = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
    $uri = str_replace("/index.php", "", $uri);
    $uri .= $path;
    return $uri;
}

$app->run();