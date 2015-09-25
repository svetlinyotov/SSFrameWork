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

class UrlRouter implements \SSFrame\Routers\RouterInterface {

    public $controller = "Home";
    public $method = "index";
    public $params = array();

    public function getURI($method = null) {
        $uri = substr($_SERVER['PHP_SELF'], strlen($_SERVER['SCRIPT_NAME']) + 1);

        $data = explode('/', $uri);

        if($data[0]){
            $this->controller = $data[0];
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




}