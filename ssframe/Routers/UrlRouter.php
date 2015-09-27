<?php

/**
 *
 * Parses the input from url
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      Routes/Route.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame\Routers;

class UrlRouter implements RouterInterface {

    public $controller = "Home";
    public $method = "index";
    public $params = array();

    public function getURI($method = null) {
        //$uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);
        $uri = $_SERVER['REQUEST_URI'];

        $data = explode('/', $uri);
        $data = array_values(array_filter($data));

        if($data[0]){
            $this->controller = config("app.controller_default_namespace") . "\\controllers\\" . ucfirst($data[0]);
            unset($data[0]);
        }
        if($data[1]){
            $this->method = $data[1];
            unset($data[1]);
        }
        $data = array_values($data);
        $this->params = $data;

        return $this;
    }


    public function getPost()
    {
        return $_POST;
    }
}