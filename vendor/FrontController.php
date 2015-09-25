<?php

/**
 *
 * Calls a router
 *
 * PHP version 5.6
 *
 * @package   SSFrame
 * @file      FrontController.php
 * @version   Release: 0.5
 * @author    Svetlin Yotov <svetlin.yotov@gmail.com>
 * @copyright 2015 SiSDevelop
 * @link      http://sisdevelop.com
 */

namespace SSFrame;

class FrontController {

    private static $_instance = null;
    private $router = null;
    public $controller = null;
    public $method = null;
    public $params = array();

    private function __construct() {
        $routerFile = config("app.router_default_path");
        if($routerFile && is_file($routerFile) && is_readable($routerFile)){
            include_once("".config("app.router_default_path")."");
        }else{
            throw new \Exception('Router file not specified', 400);
        }
    }

    /**
     * @return null
     */
    public function getRouter(){
        return $this->router;
    }

    /**
     * @param null|Routers\iRouter|Routers\RouterInterface $router
     */
    public function setRouter(\SSFrame\Routers\RouterInterface $router){
        $this->router = $router;
    }

    public function parseRouter() {

        if($this -> router == null) {
            throw new \Exception('No valid router found', 500);
        }

        $requestMethod = strtolower($_SERVER['REQUEST_METHOD']);
        $this->router->getURI($requestMethod);
        $this->controller = $this->router->controller;
        $this->method = $this->router->method;
        $this->params = $this->router->params;

        //echo '<pre>' . print_r($this->controller, true) . '</pre>';
        //echo '<pre>' . print_r($this->method, true) . '</pre>';
        //echo '<pre>' . print_r($this->params, true) . '</pre>';

        $file = config("app.controller_default_namespace").'\\' . ucfirst($this -> controller).'Controller';
        $newController = new $file();

        call_user_func_array(array($newController, $this -> method), $this->params);
    }

    public static function getInstance()
    {
        if (!self::$_instance) {
            self::$_instance = new \SSFrame\FrontController();
        }

        return self::$_instance;
    }

}