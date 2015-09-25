<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once '../../SSFrame/App.php';

$app = \SSFrame\App::getInstance();

function env($param) {
    return \SSFrame\Loader::env($param);
}
function config($param) {
    return \SSFrame\Config::get($param);
}


$app->run();
